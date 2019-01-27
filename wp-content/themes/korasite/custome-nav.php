<?php 
                function get_custome_nav_items($menu_location) {
                    $locations = get_nav_menu_locations();
                    $menu_id = $locations[$menu_location];
                    $original_menu = wp_get_nav_menu_items($menu_id);
                    // wordpress does not group child menu items with parent menu items
                    $navbar_items = wp_get_nav_menu_items($menu_id);
                    $child_items = [];
                    $all_items = array();
                    // pull all child menu items into separate object
                    foreach($navbar_items as $key=> $item) {
                        if ($item->menu_item_parent) {
                            array_push($child_items, $item);
                            unset($navbar_items[$key]);
                        }
                    }
                    // push child items into their parent item in the original object
                    foreach($original_menu as $item) {
                        foreach($original_menu as $child) {
                            // $item as $key => 
                            if ($child->menu_item_parent == $item->post_name) {
                                // echo $child->menu_item_parent;
                                // echo "ss";
                                if (!$item->child_items) $item->child_items = [];
                                array_push($item->child_items, $child);
                                unset($child_items[$key]);
                            }
                        }
                        if ($item->menu_item_parent == 0) {
                            array_push($all_items, $item);
                        }
                    }
                    return $all_items;
                    
                }