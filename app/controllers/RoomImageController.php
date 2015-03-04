<?php

class RoomImageController extends \BaseController {
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($id)
    {
            $rules = array(
                'image' => 'required|unique:roomimages,roomimage_name'
            );
            //messages
            $messages = array(
                'required' => 'Please select image to be uploaded',
            );
            
            $validator = Validator::make(Input::all(), $rules, $messages);  
            // process the login
            if (!$validator->passes()) {
                return Response::json(array('uploadedImage' => false, 'errorMessages' => $validator->messages()));
            } 
            else{
                // store
                $room = new RoomImage;
                if(Input::file('image')->isValid())
                {
                    $image = Input::file('image');
                    $filename = $image->getClientOriginalName();
                    //Check duplicated 
                    $imageExist = RoomImage::where('roomimage_name','=',$filename)->first();
                    if($imageExist){                    
                        return Response::json(array('uploadedImage' => false, 'errorMessages' => 'The uploaded image already exists'));
                    }
                    else{
                        //check for this current path first
                        if (!file_exists(public_path('img/'.$id))) {
                            mkdir(public_path('img/'.$id), 0777, true);
                        }
                        //check for another project path
                        if (!file_exists(base_path('../img/'.$id))) {
                            mkdir(base_path('../img/'.$id), 0777, true);
                        }
                        
                        $path = public_path('img/'.$id.'/'.$filename);
                        $second_path = base_path('../img/'.$id.'/'.$filename);
                        if(Image::make($image->getRealPath())->save($path)){
                                Image::make($image->getRealPath())->save($second_path);
                                $room->roomtype_id = $id;
                                $room->roomimage_name = $filename;
                                $room->roomimage_mobile = Input::get('roomimage_mobile');
                                $room->roomimage_primary = Input::get('roomimage_primary');
                                $room->roomimage_description = '/img/'.$id.'/'.$filename;
                                $room->save();
                        }
                    }
                        return json_encode(array('uploadedImage' => true, 'redirectUrl' => URL::route('showRoomType', [$id])));
                    }
                else
                {
                    return json_encode(array('uploadedImage' => false, 'errorMessages' => 'The uploaded image is invalid'));
                }
            }
    }

}
