<?php
class Application_Model_BookingService extends Application_Model_BaseModel_BaseMapper
{
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_GroupOrder';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    

    public function getBookingServiceAtSameDay($date) {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_grouporders')
                    ->where('grouporder_datetime LIKE ?', $date . '%')
                    ->where('grouporder_status = 1')
                    ->where('deleted_at IS NULL');

            // echo $select;die;

            $bookingServices = $this->getDbTable()->fetchAll($select);
            $bookingServices = $bookingServices ? $bookingServices->toArray() : Null;
            $res = array();
            foreach ($bookingServices as $bookingService) {
              // pr($bookingService);
                $res[] = new Application_Model_Order_GroupOrder($bookingService);
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }

    public function isInHCMCity($latitude, $longitude) {
      $distance = $this->haversineGreatCircleDistance($latitude, $longitude);
      return $distance <= 200;
    }

    public function getNumberOfServiceNearCurrentOrder($latitude, $longitude, $listBookingServices) {
      $listDestination = array();
      foreach ($listBookingServices as $service) {
        $listDestination[] = array(
          'latitude' => $service->getGrouporderLatitude(),
          'longitude' => $service->getGrouporderLongitude(),
        );
      }
      $listValidDestination = array();
      if (count($listDestination) > 0) {
        $listValidDestination = $this->getDistanceMapForPromotion($latitude, $longitude, $listDestination);
      }
      // pr($listValidDestination);

      $totalNumber = 0;

      foreach ($listValidDestination as $destination) {
        foreach ($listBookingServices as $service) {
          if ($service->getGrouporderLatitude() == $destination['latitude'] && 
            $service->getGrouporderLongitude() == $destination['longitude']
          ) {
            $totalNumber += $service->getGrouporderAmount();
            break;
          }
        }
      }

      return $totalNumber;
    }

    public function getDiscount($numberServiceNearby) {

    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);

      //center of HCM
      $latTo = deg2rad(10.762622);
      $lonTo = deg2rad(106.660172);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return ($angle * $earthRadius) / 1000;
    }

    private function getDistanceMapForPromotion($latitudeFrom, $longitudeFrom, $listDestination) 
    {
      $formatUrlAPI = Zend_Registry::get('configs')->google->distance->API_URL;
      $key = Zend_Registry::get('configs')->google->distance->API_KEY;
      $maxDistance = Zend_Registry::get('configs')->MAX_DISTANCE_FOR_PROMOTION;

      $destination = array();
      foreach ($listDestination as $value) {
        $destination[] = implode(',', $value);
      }
      $destination = implode('|', $destination);
      
      $api = sprintf($formatUrlAPI, $latitudeFrom, $longitudeFrom, $destination, $key);
      // pr($api);

      $query = file_get_contents($api);
      // $query = '{ "destination_addresses" : [ "72 Tản Đà, phường 11, Quận 5, Hồ Chí Minh, Vietnam" ], "origin_addresses" : [ "373 Trần Hưng Đạo, Cầu Kho, Quận 1, Hồ Chí Minh, Vietnam" ], "rows" : [ { "elements" : [ { "distance" : { "text" : "4.4 km", "value" : 840 }, "duration" : { "text" : "10 mins", "value" : 624 }, "status" : "OK" } ] } ], "status" : "OK" }';
      // echo $query; die;

      $query = json_decode($query, true);
      // pr($query);
      $res = array();
      if (isset($query["status"]) && $query['status'] == 'OK') {
        $listDistance = isset($query['rows'][0]['elements']) ? $query['rows'][0]['elements'] : array();
        $i = 0;
        foreach ($listDistance as $row) {
          $distance = isset($row['distance']['value']) ? (int)$row['distance']['value'] : 999;
          if ($distance <= $maxDistance) {
            $res[] = $listDestination[$i];
          }
          $i++;
        }
      }
      // pr($res);
      return $res;
    }
}