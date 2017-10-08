<?php

class Views_Helpers_Menu extends Zend_View_Helper_Abstract
{
  public function topMenu()
  {
    $listMenu = Application_Model_MenuMapper::getInstance()->getMenu(Application_Model_Menu::MENU_POSITION_TOP);

    $res = '';
    foreach ($listMenu as $menu) {
      $li = $this->item($menu['parent']);
      $res .= $li;
    }
    return $res;
  }

  public function bottomMenu()
  {
    $listMenu = Application_Model_MenuMapper::getInstance()->getMenu(Application_Model_Menu::MENU_POSITION_BOTTOM);
    $res = '';
    foreach ($listMenu as $menu) {
      $parent = $menu['parent'];
      $res .= '<div>';
      $res .= '<h6>'.$parent->getMenuTitle().'</h6>';
      $res .= '<ul>';
      $child = $menu['child'];
      foreach ($child as $val) {
        $res .= $this->item($val);
      }
      $res .= '</ul></div>';
    }
    return $res;
  }

  private function item($menu)
  {
    $link = $menu->getMenuAction() ? $menu->getMenuAction() : $menu->getMenuLink();
    return '<li><a href="'.$link.'">'.$menu->getMenuTitle().'</a></li>';
  }
}