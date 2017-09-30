<?php


class ThumbComponent extends Component{
  


    function doThumb($photo, $thumbWidth = 345, $thumbHeight = 259, $suffix = "") {

                   

                    $file = $photo;
                    $file_info = pathinfo($photo);


                    $imageDetails = getimagesize($file);     // Original image details
                    // Create temp resource image
                    switch ($imageDetails['mime']) {
                        case 'image/gif':
                        $img = ImageCreateFromGIF(  $file);
                        break;

                        case 'image/jpeg':
                        $img = ImageCreateFromJPEG( $file);
                        break;

                        case 'image/png':
                        $img = ImageCreateFromPNG( $file);
                        break;

                        default:
                        die;
                    }


                    $thumb_width = $thumbWidth;
                    $thumb_height = $thumbHeight;

                    $width = $imageDetails[0];
                    $height = $imageDetails[1];
                    if ( ($width < $thumb_width) && ($height < $thumb_height) ){
                        $new_name = Inflector::slug($file_info['filename']).$suffix.'.'.$file_info['extension'];
                        //$new_name = 'thumb_'.Inflector::slug($file_info['filename']).'.'.$file_info['extension'];
                        copy($photo, WWW_ROOT.'img'.DS.'uploads'.DS.'desktop'.DS.$new_name);
                    } else {
                        $original_aspect = $width / $height;
                        $thumb_aspect = $thumb_width / $thumb_height;

                        if ($original_aspect >= $thumb_aspect) {
                            // If image is wider than thumbnail (in aspect ratio sense)
                            $new_height = $thumb_height;
                            $new_width = $width / ($height / $thumb_height);
                        } else {
                            // If the thumbnail is wider than the image
                            $new_width = $thumb_width;
                            $new_height = $height / ($width / $thumb_width);
                        }

                        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

                        imagealphablending( $thumb, false  );
                        imagesavealpha( $thumb, true );

                        // Resize and crop
                        imagecopyresampled($thumb, $img, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                                0   - ($new_height - $thumb_height) / 2, // Center the image vertically
                                0, 0, $new_width, $new_height, $width, $height);

                        ob_start(); //Stdout --> buffer     

                        //$new_name = $prefix.Inflector::slug($file_info['filename']).'.'.$file_info['extension'];
                        $new_name = Inflector::slug($file_info['filename']).$suffix.'.'.$file_info['extension'];
                        $full_desktop_name =   WWW_ROOT.'img'.DS.'uploads'.DS.'desktop'.DS.$new_name;
                        $full_name =   WWW_ROOT.'img'.DS.'uploads'.DS.'mobile'.DS.$new_name;

                        switch ($imageDetails['mime']) {
                            case 'image/gif':
                            imagegif($thumb, $full_desktop_name);
                            imagegif($thumb, $full_name);
                            break;

                            case 'image/jpeg':
                            imagejpeg($thumb,  $full_desktop_name, 100);
                            imagegif($thumb, $full_name);
                            break;

                            case 'image/png':
                            imagepng($thumb, $full_desktop_name, 0);
                            imagegif($thumb, $full_name);
                            break;

                            default:
                            die;
                        }

                        ob_end_clean(); //clear buffer
                        imagedestroy($thumb); //destroy img
                    }
                    return $new_name;


                }
        
    function doSquareCrop($file, $new_height, $cx, $cy, $ch, $imageSampleHeight, $prefix = 'thumb_'){


                    
                    $file_info = pathinfo($file);

                    $imageDetails = getimagesize($file);   

                    switch ($imageDetails['mime']) {
                        case 'image/gif':
                             $img = ImageCreateFromGIF(  $file);
                        break;

                        case 'image/jpeg':
                            $img = ImageCreateFromJPEG( $file);
                        break;

                        case 'image/png':
                             $img = ImageCreateFromPNG( $file);
                        break;

                        default:
                        die;
                    }



                    $height = $imageDetails[1];
                   
                     $ratio =  $height/$imageSampleHeight;
                     $cx = $ratio * $cx;
                      $cy = $ratio * $cy;
                       $ch = $ratio * $ch;
                   


                     $thumb = imagecreatetruecolor( $new_height,  $new_height);

                     imagealphablending( $thumb, false  );
                     imagesavealpha( $thumb, true );

                    imagecopyresampled($thumb, $img, 0, 0,  $cx,$cy, $new_height, $new_height, $ch,$ch);

                    $filename = $prefix.Inflector::slug($file_info['filename']).'.'.$file_info['extension'];
                    $complete_path = WWW_ROOT.'img'.DS.'uploads'.DS.$filename;
                    ob_start(); //Stdout --> buffer      

                    switch ($imageDetails['mime']) {
                        case 'image/gif':
                             imagegif($thumb,  $complete_path);
                        break;

                        case 'image/jpeg':
                             imagejpeg($thumb, $complete_path, 100);
                        break;

                        case 'image/png':
                             imagepng($thumb,  $complete_path, 0);
                        break;

                        default:
                        die;
                    }

                    ob_end_clean(); //clear buffer
                    imagedestroy($thumb); //destroy img

                    return $filename; 

              }   



   function doCrop($file, $cx, $cy, $ch,$cw, $imagewidth, $prefix = 'thumb_'){


        
        $file_info = pathinfo($file);

        $imageDetails = getimagesize($file);   

        switch ($imageDetails['mime']) {
            case 'image/gif':
                 $img = ImageCreateFromGIF(  $file);
            break;

            case 'image/jpeg':
                $img = ImageCreateFromJPEG( $file);
            break;

            case 'image/png':
                 $img = ImageCreateFromPNG( $file);
            break;

            default:
            die;
        }



        $width = $imageDetails[0];
       
         $ratio =  $width/$imagewidth;
         $cx = $ratio * $cx;
         $cy = $ratio * $cy;
         $ch = $ratio * $ch;
         $cw = $ratio * $cw;
       


         $thumb = imagecreatetruecolor( $cw,  $ch);

         imagealphablending( $thumb, false  );
         imagesavealpha( $thumb, true );

        imagecopyresampled($thumb, $img, 0, 0,  $cx,$cy, $cw, $ch, $cw,$ch);

        $filename = $prefix.Inflector::slug($file_info['filename']).'.'.$file_info['extension'];
        $complete_path = WWW_ROOT.'img'.DS.'uploads'.DS.$filename;
        ob_start(); //Stdout --> buffer      

        switch ($imageDetails['mime']) {
            case 'image/gif':
                 imagegif($thumb,  $complete_path);
            break;

            case 'image/jpeg':
                 imagejpeg($thumb, $complete_path, 100);
            break;

            case 'image/png':
                 imagepng($thumb,  $complete_path, 0);
            break;

            default:
            die;
        }

        ob_end_clean(); //clear buffer
        imagedestroy($thumb); //destroy img

        return $filename; 

  }   

 }
