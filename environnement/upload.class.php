<?php
/**
 * This class allows a user to upload and validate their files.
 *
 * @author John Ciacia 
 * @version 1.0
 * @copyright Copyright (c) 2007, John Ciacia
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Upload {
 
    /**
     *@var string contains the name of the file to be uploaded.
     */
    var $FileName;
    /**
     *@var string contains the temporary name of the file to be uploaded.
     */
    var $TempFileName;
    /**
     *@var string contains directory where the files should be uploaded.
     */
    var $UploadDirectory;
    /**
     *@var string contains an array of valid extensions which are allowed to be uploaded.
     */
    var $ValidExtensions;
    /**
     *@var string contains a message which can be used for debugging.
     */
    var $Message;
    /**
     *@var integer contains maximum size of fiels to be uploaded in bytes.
     */
    var $MaximumFileSize;
    /**
     *@var bool contains whether or not the files being uploaded are images.
     */
    var $IsImage;
    /**
     *@var integer contains maximum width of images to be uploaded.
     */
    var $MaximumWidth;
    /**
     *@var integer contains maximum height of images to be uploaded.
     */
    var $MaximumHeight;
 
    function Upload()
    {
 
    }
 
 
    /**
      *connection a la base de donnée
     */
	 function connexion_DB()
	 {
		try
					{
						 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
					}
				catch (Exception $e)
					{
						  die('Erreur : ' . $e->getMessage());
					}
	 }
    /**
     *@method bool ValidateExtension() returns whether the extension of file to be uploaded
     *    is allowable or not.
     *@return true the extension is valid.
     *@return false the extension is invalid.
     */
    function ValidateExtension()
    {
 
        $FileName = trim($this->FileName);
        $FileParts = pathinfo($FileName);
        $Extension = strtolower($FileParts['extension']);
        $ValidExtensions = $this->ValidExtensions;
 
        if (!$FileName) {
            $this->SetMessage("ERROR: File name is empty.");
            return false;
        }
 
        if (!$ValidExtensions) {
            $this->SetMessage("WARNING: All extensions are valid.");
            return true;
        }
 
        if (in_array($Extension, $ValidExtensions)) {
            $this->SetMessage("MESSAGE: The extension '$Extension' appears to be valid.");
            return true;
        } else {
            $this->SetMessage("Error: The extension '$Extension' is invalid.");
            return false;  
        }
 //return 'png';
    }
 
    /**
     *@method bool ValidateSize() returns whether the file size is acceptable.
     *@return true the size is smaller than the alloted value.
     *@return false the size is larger than the alloted value.
     */
    function ValidateSize()
    {
        $MaximumFileSize = $this->MaximumFileSize;
        $TempFileName = $this->GetTempName();
        $TempFileSize = filesize($TempFileName);
 
        if($MaximumFileSize == "") {
            $this->SetMessage("WARNING: There is no size restriction.");
            return true;
        }
 
        if ($MaximumFileSize <= $TempFileSize) {
            $this->SetMessage("ERROR: The file is too big. It must be less than $MaximumFileSize and it is $TempFileSize.");
            return false;
        }
 
        $this->SetMessage("Message: The file size is less than the MaximumFileSize.");
        return true;
    }
 
    /**
     *@method bool ValidateExistance() determins whether the file already exists. If so, rename $FileName.
     *@return true can never be returned as all file names must be unique.
     *@return false the file name does not exist.
     */
    function ValidateExistance()
    {
        $FileName = $this->FileName;
        $UploadDirectory = $this->UploadDirectory;
        $File = $UploadDirectory . $FileName;
 
        if (file_exists($File)) {
            $this->SetMessage("Message: The file '$FileName' already exist.");
            $UniqueName = rand() . $FileName;
            $this->SetFileName($UniqueName);
            $this->ValidateExistance();
        } else {
            $this->SetMessage("Message: The file name '$FileName' does not exist.");
            return false;
        }
    }
 
    /**
     *@method bool ValidateDirectory()
     *@return true the UploadDirectory exists, writable, and has a traling slash.
     *@return false the directory was never set, does not exist, or is not writable.
     */
    function ValidateDirectory()
    {
        $UploadDirectory = $this->UploadDirectory;
 
        if (!$UploadDirectory) {
            $this->SetMessage("ERROR: The directory variable is empty.");
            return false;
        }
 
        if (!is_dir($UploadDirectory)) {
            $this->SetMessage("ERROR: The directory '$UploadDirectory' does not exist.");
            return false;
        }
 
        if (!is_writable($UploadDirectory)) {
            $this->SetMessage("ERROR: The directory '$UploadDirectory' does not writable.");
            return false;
        }
 
        if (substr($UploadDirectory, -1) != "/") {
            $this->SetMessage("ERROR: The traling slash does not exist.");
            $NewDirectory = $UploadDirectory . "/";
            $this->SetUploadDirectory($NewDirectory);
            $this->ValidateDirectory();
        } else {
            $this->SetMessage("MESSAGE: The traling slash exist.");
            return true;
			//return false;
        }
    }
 
    /**
     *@method bool ValidateImage()
     *@return true the image is smaller than the alloted dimensions.
     *@return false the width and/or height is larger then the alloted dimensions.
     */
    /*function ValidateImage() {
        $MaximumWidth = $this->MaximumWidth;
        $MaximumHeight = $this->MaximumHeight;
        $TempFileName = $this->TempFileName;
 
    if($Size = @getimagesize($TempFileName)) {
        $Width = $Size[0];   //$Width is the width in pixels of the image uploaded to the server.
        $Height = $Size[1];  //$Height is the height in pixels of the image uploaded to the server.
    }
 
        if ($Width > $MaximumWidth) {
            $this->SetMessage("The width of the image [$Width] exceeds the maximum amount [$MaximumWidth].");
            return false;
        }
 
        if ($Height > $MaximumHeight) {
            $this->SetMessage("The height of the image [$Height] exceeds the maximum amount [$MaximumHeight].");
            return false;
        }
 
        $this->SetMessage("The image height [$Height] and width [$Width] are within their limitations.");     
        return true;
    }*/
 
    /**
     *@method bool UploadFile() uploads the file to the server after passing all the validations.
     *@return true the file was uploaded.
     *@return false the upload failed.
     */
	 function saveFile()
	 {
	 $FileName=$_SESSION["FileName"];
	 $token_file=$_SESSION['token_file'];
	 $extension=$_SESSION["type_file"];
	 $Size=$_SESSION["size_file"];
	 $location_file=$_SERVER['DOCUMENT_ROOT'].'/LemZoun/environnement/donnee/'.$FileName;
	 $nom_tag=$_SESSION['tag'];
	 $_SERVER['PHP_AUTH_USER']=$_SESSION['id_utilisateur'];
	 //$location_file=$_SERVER['DOCUMENT_ROOT'].'/LemZoun/environnement/donnee/'.$FileName.$id_user;
	 $Email=$_SERVER['PHP_AUTH_USER'];
	try
            {
                 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
		
        $reponse = $bdd->query("SELECT id_user FROM lz_user where Email='$Email'");
		$donnees = $reponse->fetch();
		
		if (isset($donnees) && $donnees != 0)
		{
		$id_user=$donnees['id_user'];
		//$location_file=$_SERVER['DOCUMENT_ROOT'].'/LemZoun/environnement/donnee/'.$FileName.$id_user;
		//}
	   //$conn=mysql_connect("localhost","root","") or die(mysql_error());
				
		//$sql = "INSERT INTO lz_fichier (id_file,id_user,nom_file,nom_tag,type_file,size_file ,location_file) VALUES ( '', '$id_user','$FileName','$nom_tag','$extension','$Size ' ,'$location_file' )";
				
		//		mysql_select_db("cloud") or die(mysql_error());
		//		$retval = mysql_query( $sql, $conn );
		$bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file,location_file)VALUES('', '$id_user','$FileName','$token_file','$nom_tag','$extension','$Size ' ,'$location_file')");  
				
				//mysql_close($conn);
		}
	 }
    function UploadFile()
    {


		//$FileName = $this->FileName;
        //$UploadDirectory = $this->UploadDirectory;
        //$File = $UploadDirectory . $FileName;
 
        /*if (file_exists($File)) {
            $this->SetMessage("Message: The file '$FileName' already exist.");
			die($this->GetMessage());
			}*/
        if (!$this->ValidateExtension()) {
            die($this->GetMessage());
        } 
 
        else if (!$this->ValidateSize()) {
            die($this->GetMessage());
        }
		else if ($this->ValidateExistance()) {
            die($this->GetMessage());
        }
 
        
 
        else if (!$this->ValidateDirectory()) {
            die($this->GetMessage());
        }
 
        /*else if ($this->IsImage && !$this->ValidateImage()) 
		{
            die($this->GetMessage());
        }*/
 
        else {
 
            $FileName = trim($this->FileName);
            $TempFileName = $this->TempFileName;
            $UploadDirectory = $this->UploadDirectory;
 
            if (is_uploaded_file($TempFileName))
			{ 
				//retourner l extension d un fichier
				$info = new SplFileInfo($FileName);
				$extension=$info->getExtension();
		
				//retourner la size d un fichier
				$TempFileName = $this->GetTempName();
				$Size = filesize($TempFileName);
				
		
                move_uploaded_file($TempFileName, $UploadDirectory . $FileName);
				
				$location_file=$UploadDirectory . $FileName;
				
				$_SESSION['type_file']=$extension;
				$_SESSION['size_file']=$Size ;	
				$_SESSION['location_file']=$location_file;	
                return true;
            } 
			else 
			{
                return false;
            }
 
        }
 
    }
 
    #Accessors and Mutators beyond this point.
    #Siginificant documentation is not needed.
    function SetFileName($argv)
    {
        $this->FileName = $argv;
    }
 
    function SetUploadDirectory($argv)
    {
        $this->UploadDirectory = $argv;
    }
 
    function SetTempName($argv)
    {
        $this->TempFileName = $argv;
    }
 
    function SetValidExtensions($argv)
    {
        $this->ValidExtensions = $argv;
    }
 
    function SetMessage($argv)
    {
        $this->Message = $argv;
    }
 
    function SetMaximumFileSize($argv)
    {
        $this->MaximumFileSize = $argv;
    }    
 
    function SetIsImage($argv)
    {
        $this->IsImage = $argv;
    }
 
    function SetMaximumWidth($argv)
    {
        $this->MaximumWidth = $argv;
    }
 
    function SetMaximumHeight($argv)
    {
        $this->MaximumHeight = $argv;
    }   
    function GetFileName()
    {
        return $this->FileName;
    }
 
    function GetUploadDirectory()
    {
        return $this->UploadDirectory;
    }
 
    function GetTempName()
    {
        return $this->TempFileName;
    }
 
    function GetValidExtensions()
    {
        return $this->ValidExtensions;
    }
 
    function GetMessage()
    {
        if (!isset($this->Message)) {
            $this->SetMessage("No Message");
        }
 
        return $this->Message;
    }
 
    function GetMaximumFileSize()
    {
        return $this->MaximumFileSize;
    }
 
    function GetIsImage()
    {
        return $this->IsImage;
    }
 
    function GetMaximumWidth()
    {
        return $this->MaximumWidth;
    }
 
    function GetMaximumHeight()
    {
        return $this->MaximumHeight;
    }
	

}
?>
