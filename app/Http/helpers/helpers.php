<?php

use App\Role;
use App\Permission;

function Permissions()
{
    $routes = Route::getRoutes();
    foreach ($routes as $value) {

        if (isset($value->getAction()['title'])) {
            echo '<div class="col-sm-12" >';
            echo '<label class="checkbox" >';
            echo '<input type="checkbox" name="permissions[]" value="' . $value->getName() . '"> ';
            echo '<i class="icon-checkbox"></i>';
            echo '<label class="checkbox" style="padding-right:8px">' . $value->getAction()['title'] . '</label>';
            echo '</label>';
            echo '</div>';
        }
    }
}



function Permissions3()
{
    $routes = Route::getRoutes();
    $output = [
        'admin' => '',
        'trainer' => '',
        'student' => ''
    ];
    echo '<ul id="tree1">';
    foreach ($routes as $value) {
        if (isset($value->getAction()['title']) && isset($value->getAction()['child'])) {
            $group = 'admin';
            if (strpos($value->getAction()['uses'], 'App\\Http\\Controllers\\Trainer\\') === 0) {
                $group = 'trainer';
            } elseif (strpos($value->getAction()['uses'], 'App\\Http\\Controllers\\Student\\') === 0) {
                $group = 'student';
            }

            $output[$group] .= '<li><label class="kt-checkbox"><input type="checkbox" name="permissions[]"  value="' . $value->getName() . '"><span></span> </label><a href="#">' . $value->getAction()['title'] . '</a><br><ul>';

            foreach ($value->getAction()['child'] as $child) {

                #foreach for sub links
                //$routes = Route::getRoutes();

                foreach ($routes as $value) {
                    if ($value->getName() !== null && $value->getName() === $child) {
                        $output[$group] .= '<li>' . $value->getAction()['title'];
                        $output[$group] .= '<div class="kt-checkbox-single"><label class="kt-checkbox">';
                        $output[$group] .= '<input type="checkbox" class="form-control" name="permissions[]" value="' . $value->getName() . '"> ';
                        $output[$group] .= ' <span></span> </label>';
                        $output[$group] .= ' </li>';
                    }
                }
            }
            $output[$group] .= '</ul></li>';
        }
    }

    echo '<li><label class="kt-checkbox"><input type="checkbox" value=""><span></span> </label><a href="#">' . __('pages.Admin') . '</a><br><ul>';
    echo $output['admin'];
    echo '</ul></li>';

    echo '<li><label class="kt-checkbox"><input type="checkbox" value=""><span></span> </label><a href="#">' . __('pages.Trainer') . '</a><br><ul>';
    echo $output['trainer'];
    echo '</ul></li>';

    echo '<li><label class="kt-checkbox"><input type="checkbox" value=""><span></span> </label><a href="#">' . __('pages.Student') . '</a><br><ul>';
    echo $output['student'];
    echo '</ul></li>';

    echo '</ul>';
}



//function Permissions3()
//{
//    $routes = Route::getRoutes();
//
//    echo '<ul id="tree1">';
//    foreach ($routes as $value)
//    {
//        if(isset($value->getAction()['title']) && isset($value->getAction()['child']))
//        {
//            echo '<div class="col-sm-12"><label class="kt-checkbox"><input type="checkbox" name="permissions[]"  value="'.$value->getName().'"><span></span> </label><li><a href="#">'.$value->getAction()['title'].'</a><br>';
//
//            foreach ($value->getAction()['child'] as $child)
//            {
//
//                #foreach for sub links
//                $routes = Route::getRoutes();
//                foreach ($routes as $value)
//                {
//                    if($value->getName() !== null && $value->getName() === $child)
//                    {
//                        echo '<ul><li>'.$value->getAction()['title'].'</li>';
//                        echo '<div class="kt-checkbox-single"><label class="kt-checkbox">';
//                        echo '<input type="checkbox" class="form-control" name="permissions[]" value="'.$value->getName().'"> ';
//                        echo ' <span></span> </label>';
//                        echo ' </ul>';
//                    }
//                }
//            }
//            echo '</div>';
//
//        }
//    }
//    echo '</li></ul>';
//}

function EditPermissions3($id)
{
    $arr = [];
    $permission = Permission::where('role_id', $id)->select('permissions')->get();
    foreach ($permission as $key => $per) {
        $arr[$key] = $per->permissions;
    }

    $routes = Route::getRoutes();

    $output = [
        'admin' => '',
        'trainer' => '',
        'student' => ''
    ];

    $failedCounter = [
        'admin' => 0,
        'trainer' => 0,
        'student' => 0
    ];

    $successCounter = [
        'admin' => 0,
        'trainer' => 0,
        'student' => 0
    ];

    echo '<ul id="tree1">';
    foreach ($routes as $value) {
        if (isset($value->getAction()['title']) && isset($value->getAction()['child'])) {
            $group = 'admin';
            if (strpos($value->getAction()['uses'], 'App\\Http\\Controllers\\Trainer\\') === 0) {
                $group = 'trainer';
            } elseif (strpos($value->getAction()['uses'], 'App\\Http\\Controllers\\Student\\') === 0) {
                $group = 'student';
            }
            $checked = '';
            if (in_array($value->getName(), $arr)) {
                $checked = 'checked';
                $successCounter[$group] = $successCounter[$group] + 1;
            } else {
                $failedCounter[$group] = $failedCounter[$group] + 1;
            }
            $output[$group] .= '<li><label class="kt-checkbox"><input type="checkbox" ' . $checked . ' name="permissions[]"  value="' . $value->getName() . '"><span></span> </label><a href="#">' . $value->getAction()['title'] . '</a><br><ul>';

            // /*if(in_array($value->getName(),$arr))
            // {
            //     echo '<div class="col-sm-3"><li><label class="kt-checkbox"><input type="checkbox"  name="permissions[]"  value="'.$value->getName().'"><span></span></label><a href="#">'.$value->getAction()['title'].'</a><br><ul>';
            // }else{
            //     echo '<div class="col-sm-3"><li><label class="kt-checkbox"><input type="checkbox"  name="permissions[]"  value="'.$value->getName().'"><span></span></label><a href="#">'.$value->getAction()['title'].'</a><br><ul>';

            // }*/
            foreach ($value->getAction()['child'] as $child) {

                #foreach for sub links
                //$routes = Route::getRoutes();
                foreach ($routes as $value) {
                    if ($value->getName() !== null && $value->getName() === $child) {
                        $output[$group] .= '<li>' . $value->getAction()['title'];
                        $output[$group] .= '<div class="kt-checkbox-single"><label class="kt-checkbox">';
                        if (in_array($value->getName(), $arr)) {
                            $output[$group] .= '<input type="checkbox" class="form-control" checked="" name="permissions[]" value="' . $value->getName() . '"> ';
                        } else {
                            $output[$group] .= '<input type="checkbox" class="form-control" name="permissions[]" value="' . $value->getName() . '"> ';
                        }
                        $output[$group] .= ' <span></span> </label>';
                        $output[$group] .= ' </li>';
                    }
                }
            }
            $output[$group] .= '</ul></li>';
        }
    }

    $checked = '';
    if ($successCounter['admin'] != 0) {
        $checked = 'checked';
    }
    echo '<li><label class="kt-checkbox"><input type="checkbox" ' . $checked . ' value=""><span></span> </label><a href="#">' . __('pages.Admin') . '</a><br><ul>';
    echo $output['admin'];
    echo '</ul></li>';

    $checked = '';
    if ($successCounter['trainer'] != 0) {
        $checked = 'checked';
    }
    echo '<li><label class="kt-checkbox"><input type="checkbox" ' . $checked . ' value=""><span></span> </label><a href="#">' . __('pages.Trainer') . '</a><br><ul>';
    echo $output['trainer'];
    echo '</ul></li>';

    $checked = '';
    if ($successCounter['student'] != 0) {
        $checked = 'checked';
    }
    echo '<li><label class="kt-checkbox"><input type="checkbox" ' . $checked . ' value=""><span></span> </label><a href="#">' . __('pages.Student') . '</a><br><ul>';
    echo $output['student'];
    echo '</ul></li>';

    echo '</ul>';
}



//function EditPermissions3($id)
//{
//
//
//
//    echo '<ul id="tree1">';
//    foreach ($routes as $value)
//    {
//        if(isset($value->getAction()['title']) && isset($value->getAction()['child']))
//        {
//            if(in_array($value->getName(),$arr))
//            {
//                echo '<div class="col-sm-3"><li><label class="kt-checkbox"><input type="checkbox" checked name="permissions[]"  value="'.$value->getName().'"><span></span> </label><a href="#">'.$value->getAction()['title'].'</a><br><ul>';
//
////                echo '<div class="col-sm-12"><label class="kt-checkbox"><input type="checkbox" checked name="permissions[]"  value="'.$value->getName().'"><span></span> </label><li><a href="#">'.$value->getAction()['title'].'</a><br>';
//            }else{
//                echo '<div class="col-sm-3"><li><label class="kt-checkbox"><input type="checkbox"  name="permissions[]"  value="'.$value->getName().'"><span></span> </label><a href="#">'.$value->getAction()['title'].'</a><br><ul>';
//
////                echo '<div class="col-sm-12"><label class="kt-checkbox"><input type="checkbox" name="permissions[]"  value="'.$value->getName().'"><span></span> </label><li><a href="#">'.$value->getAction()['title'].'</a><br>';
//            }
//            foreach ($value->getAction()['child'] as $child)
//            {
//
//                #foreach for sub links
//                $routes = Route::getRoutes();
//                foreach ($routes as $value)
//                {
//                    if($value->getName() !== null && $value->getName() === $child)
//                    {
//
//                        echo '<li>'.$value->getAction()['title'];
//                        echo '<div class="kt-checkbox-single"><label class="kt-checkbox">';
//                            if(in_array($value->getName(),$arr))
//                            {
//                                echo '<input type="checkbox" class="form-control" checked=""  name="permissions[]" value="'.$value->getName().'"> ';
//
//                                //  echo '<input type="checkbox" class="form-control" checked="" name="permissions[]" value="'.$value->getName().'"> ';
//                            }else{
//                                echo '<input type="checkbox" class="form-control" name="permissions[]" value="'.$value->getName().'"> ';
//
////                                echo '<input type="checkbox" class="form-control" name="permissions[]" value="'.$value->getName().'"> ';
//                            }
//                            echo ' <span></span> </label>';
//                        echo ' </li>';
//
//
////                        echo '<li>'.$value->getAction()['title'];
////                        echo '<div class="kt-checkbox-single"><label class="kt-checkbox">';
////                        echo '<input type="checkbox" class="form-control" name="permissions[]" value="'.$value->getName().'"> ';
////                        echo ' <span></span> </label>';
////                        echo ' </li>';
//
//                    }
//                }
//            }
//            echo '</ul></div></li>';
//
//        }
//    }
//    echo '</ul>';
//
//
//
//
//
//
//
//
//
//    // foreach ($routes as $value)
//    // {
//    //     if(isset($value->getAction()['title']))
//    //     {
//    //         if(in_array($value->getName(),$arr))
//    //         {
//    //             echo '<div class="col-sm-12" >';
//    //                 echo '<label class="checkbox" >';
//    //                 echo '<input type="checkbox" name="permissions[]" checked value="'.$value->getName().'"> ';
//    //                 echo '<i class="icon-checkbox"></i>';
//    //                 echo '<label class="checkbox" style="padding-right:8px">'.$value->getAction()['title'].'</label>';
//    //                 echo '</label>';
//    //             echo '</div>';
//    //         }else
//    //         {
//    //             echo '<div class="col-sm-12" >';
//    //                 echo '<label class="checkbox" >';
//    //                 echo '<input type="checkbox" name="permissions[]" value="'.$value->getName().'"> ';
//    //                 echo '<i class="icon-checkbox"></i>';
//    //                 echo '<label class="checkbox" style="padding-right:8px">'.$value->getAction()['title'].'</label>';
//    //                 echo '</label>';
//    //             echo '</div>';
//    //         }
//    //     }
//    // }
//}


function EditPermissions($id)
{

    $arr = [];
    $permission = Permission::where('role_id', $id)->select('permissions')->get();
    foreach ($permission as $key => $per) {
        $arr[$key] = $per->permissions;
    }

    $routes = Route::getRoutes();
    foreach ($routes as $value) {
        if (isset($value->getAction()['title'])) {
            if (in_array($value->getName(), $arr)) {
                echo '<div class="col-sm-12" >';
                echo '<label class="checkbox" >';
                echo '<input type="checkbox" name="permissions[]" checked value="' . $value->getName() . '"> ';
                echo '<i class="icon-checkbox"></i>';
                echo '<label class="checkbox" style="padding-right:8px">' . $value->getAction()['title'] . '</label>';
                echo '</label>';
                echo '</div>';
            } else {
                echo '<div class="col-sm-12" >';
                echo '<label class="checkbox" >';
                echo '<input type="checkbox" name="permissions[]" value="' . $value->getName() . '"> ';
                echo '<i class="icon-checkbox"></i>';
                echo '<label class="checkbox" style="padding-right:8px">' . $value->getAction()['title'] . '</label>';
                echo '</label>';
                echo '</div>';
            }
        }
    }
}

function checkPermission($url)
{
    $arr = [];
    $permission = Permission::where('role_id', auth()->user()->role)->select('permissions')->get();
    foreach ($permission as $key => $per) {
        $arr[$key] = $per->permissions;
    }

    if (in_array($url, $arr) != false) {
        return true;
    } else {
        return false;
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}



// function EditPermissions($id)
// {
// 	$routes = Route::getRoutes();
// 	foreach ($routes as $value)
// 	{
// 		if($value->getName() !== null)
// 		{
// 			if(isset($value->getAction()['title']) && !isset($value->getAction()['front']) && isset($value->getAction()['child']))
// 			{

//                 $arr = [];
//                 $permission = Permission::where('role_id',$id)->select('permissions')->get();
//                 foreach($permission as $key=>$per)
//                 {
//                     $arr[$key] = $per->permissions;
//                 }


//                 echo '<div class="col-sm-4" style="border: 1px solid #000;margin-right:7px;margin-bottom:5px;padding:0">';
//                 foreach ($value->getAction()['child'] as $child)
//                 {

//                     if(isset($value->getAction()['title']))
//                     {
//                         if(in_array($value->getName(),$arr))
//                         {
//                             echo '<label class="checkbox" style="display:block;background:#37474f;margin-top:0;color:#fff">';
//                             echo '<input type="checkbox" name="permissions[]" checked value="'.$value->getName().'"> ';
//                             echo '<i class="icon-checkbox"></i>';
//                             echo '<label class="checkbox" style="padding-right:8px">'.$value->getAction()['title'].'</label>';
//                             echo '</label>';    
//                         }else
//                         {
//                             echo '<label class="checkbox" style="display:block;background:#37474f;margin-top:0;color:#fff">';
//                             echo '<input type="checkbox" name="permissions[]" value="'.$value->getName().'"> ';    
//                             echo '<i class="icon-checkbox"></i>';
//                            echo '<label class="checkbox" style="padding-right:8px">'.$value->getAction()['title'].'</label>';
//                             echo '</label>'; 
//                         }
//                     }

//                     #????
//                     if(isset($value->getAction()['subTitle']))
//                     {
//                         if(in_array($value->getName(),$arr))
//                         {
//                             echo '<label class="checkbox" style="display:block">';
//                             echo '<input type="checkbox" name="permissions[]" checked value="'.$value->getName().'"> ';
//                             echo '<i class="icon-checkbox"></i>';
//                             echo '<label style="padding-right:8px">'.$value->getAction()['subTitle'].'</label><br>';
//                             echo '</label>';
//                         }else
//                         {
//                             echo '<label class="checkbox" style="display:block">';
//                             echo '<input type="checkbox" name="permissions[]" value="'.$value->getName().'"> ';
//                             echo '<i class="icon-checkbox"></i>';
//                             echo '<label style="padding-right:8px">'.$value->getAction()['subTitle'].'</label><br>';
//                             echo '</label>';
//                         }
//                     }

//                     #foreach for sub links
//                     $routes = Route::getRoutes();
//                     foreach ($routes as $value)
//                     {
//                         if($value->getName() !== null && !isset($value->getAction()['icon']) || isset($value->getAction()['hasFather']))

//                         {
//                             if($value->getName() == $child)
//                             {
//                                 if(in_array($value->getName(),$arr))
//                                 {
//                                     echo '<label class="checkbox" style="display:block">';
//                                     echo '<input type="checkbox" name="permissions[]" checked  value="'.$value->getName().'"> ';
//                                     echo '<i class="icon-checkbox"></i>';
//                                     echo '<label style="padding-right:8px">'.$value->getAction()['title'].'</label><br>';
//                                     echo '</label>';
//                                 }else
//                                 {
//                                     echo '<label class="checkbox" style="display:block">';
//                                     echo '<input type="checkbox" name="permissions[]"  value="'.$value->getName().'"> ';
//                                     echo '<i class="icon-checkbox"></i>';
//                                     echo '<label style="padding-right:8px">'.$value->getAction()['title'].'</label><br>';
//                                     echo '</label>';
//                                 }
//                             }
//                         }
//                     }

//                 }
//                 echo '</div>';
//             }
//             if(!isset($value->getAction()['child']) && isset($value->getAction()['icon']) && !isset($value->getAction()['front']) && isset($value->getAction()['title']) && !isset($value->getAction()['hasFather']))
//             {
//                 $arr = [];
//                 $permission = Permission::where('role_id',$id)->select('permissions')->get();
//                 foreach($permission as $key=>$per)
//                 {
//                     $arr[$key] = $per->permissions;
//                 }

//                 echo '<div class="col-sm-3" style="border: 1px solid #000;margin-right:10px;margin-bottom:5px;padding:0;background:#eee">';
//                 if(in_array($value->getName(),$arr))
//                 {
//                     echo '<label class="checkbox" style="display:block;background:#37474f;margin-top:0;margin-bottom:0;color:#fff">';
//                     echo '<input type="checkbox" name="permissions[]" checked  value="'.$value->getName().'"> ';
//                     echo '<i class="icon-checkbox"></i>';
//                     echo '<label style="padding-right:8px ;margin-top:6px">'.$value->getAction()['title'].'</label><br>';
//                     echo '</label>';
//                 }else
//                 {
//                     echo '<label class="checkbox" style="display:block;background:#37474f;margin-top:0;margin-bottom:0;color:#fff">';
//                     echo '<input type="checkbox" name="permissions[]"  value="'.$value->getName().'"> ';
//                     echo '<i class="icon-checkbox"></i>';
//                      echo '<label style="padding-right:8px ;margin-top:6px">'.$value->getAction()['title'].'</label><br>';
//                      echo '</label>';
//                 }
//                 echo '</div>';
//             }
// 		} 
// 	}	
// }


if (!function_exists('get_period_name')) {
    function get_period_name($period_type)
    {
        $period_name = 'ايام';
        switch ($period_type) {
            case  'day':
                $period_name = 'ايام';
                break;
            case 'hour':
                $period_name = 'ساعة';
                break;
            case 'week':
                $period_name = 'اسبوع';
                break;
            case 'month':
                $period_name = 'شهر';
                break;
        }
        return $period_name;
    }
}