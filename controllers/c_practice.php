
<?php 
class practice_controller extends base_controller{
	
	public function test1(){
		#echo "you are loooking at test1";

		require(APP_PATH.'/libraries/Image.php');

		$imageObj = new Image('http://students.dwa15.com/uploads/avatars/138._200_200.jpg');

        /*
        Call the resize method on this object using the object operator (single arrow ->) 
        which is used to access methods and properties of an object
        */
        $imageObj->resize(200,200);

        # Display the resized image
        $imageObj->display();

	}


}
