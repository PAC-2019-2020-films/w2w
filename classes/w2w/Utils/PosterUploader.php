<?php

namespace w2w\Utils;

use \w2w\Model\Movie;
use \w2w\Utils\Notification;

class PosterUploader
{
    
    protected $overwrite = true;
    protected $spaceReplacement = "_";
    protected $maxSize = 1048576; // 1024*1024
    protected $ignoreExifNotAvailable = true; // not safe for prod
    protected $posterSuffix = "-medium";
    protected $inputFileName = "poster-file";
    
    
    /**
     * Whether a form has been sent with an attempt to upload a poster.
     */
    public function hasUpload()
    {
        if (isset($_FILES[$this->inputFileName]) && $_FILES[$this->inputFileName]["error"] != UPLOAD_ERR_NO_FILE) {
            return true;
        }
        return false;
    }
    
    /**
     * Effectue l'upload.
     * 
     * - lance une exception en cas d'erreur interne à l'application
     * - ajoute une erreur dans Notification pour des erreurs utilisateur
     */
    public function upload(Movie $movie, Notification $notification, $validateOnly = false)
    {
        if (! isset($_FILES[$this->inputFileName])) {
            throw new \Exception("Bad poster file upload name (change file input name in html form).");
        }
        if (! defined("IMG_PATH_MOVIES")) {
            throw new \Exception("Upload directory constant not defined (define 'IMG_PATH_MOVIES' with a path in 'index.php').");
        }
        if (! is_dir(IMG_PATH_MOVIES)) {
            throw new \Exception(sprintf("Upload directory is not a directory ('%s').", IMG_PATH_MOVIES));
        }
        if (! is_writable(IMG_PATH_MOVIES)) {
            throw new \Exception(sprintf("Upload directory is not writable ('%s').", IMG_PATH_MOVIES));
        }
        switch ($_FILES[$this->inputFileName]["error"]) {
            case UPLOAD_ERR_OK :
                break;
            case UPLOAD_ERR_INI_SIZE :
            case UPLOAD_ERR_FORM_SIZE :
                $notification->addError("Fichier trop volumineux.");
                break;
            case UPLOAD_ERR_PARTIAL :
                $notification->addError("Upload du ficher incomplet. Veuillez réessayer.");
                break;
            case UPLOAD_ERR_NO_FILE :
                $notification->addError("Pas de fichier d'upload reçu.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR :
                throw new \Exception("PHP upload error : Un dossier temporaire est manquant.");
            case UPLOAD_ERR_CANT_WRITE :
                throw new \Exception("PHP upload error : Échec de l'écriture du fichier sur le disque.");
            case UPLOAD_ERR_EXTENSION :
                throw new \Exception("PHP upload error : Une extension PHP a arrêté l'envoi de fichier.");
        }

        # Choix nom fichier :
        $poster = $movie->getPoster();
        if (! $poster) {
            $poster = str_replace(" ", $this->spaceReplacement, strtolower($movie->getTitle()));
        }
        if (! $poster) {
            $notification->addError("Empty poster filename value while uploading file not allowed.");
        }
        
        $filePathFrom = $_FILES[$this->inputFileName]["tmp_name"];
        $filePathTo   = IMG_PATH_MOVIES . $poster . $this->posterSuffix . ".jpg";

        # Vérification taille fichier :
        if ($_FILES[$this->inputFileName]["size"] > $this->maxSize) {
            $notification->addError(sprintf("Poster file too big (max : %0.1d Kb).", $this->maxSize / 1024));
        }
        
        # On vérifie le type de l'image (deux premiers octets, nombre magique...) :
        # ($_FILES['userfile']['type'] = mimetype fourni par client, pas fiable)
        if (function_exists("exif_imagetype")) {
            if (exif_imagetype($filePathFrom) != IMAGETYPE_JPEG) {
                $notification->addError("Poster file not a valid jpg image.");
            }
        } else {
            if (! $this->ignoreExifNotAvailable) {
                throw new \Exception("Unable to check poster file type (no Exif extension).");
            }
        }
        
        # Si fichier existe déjà ? 
        if (file_exists($filePathTo) && ! $this->overwrite) {
            $notification->addError("Poster file with same name already exists and overwriting not allowed.");
        }
        
        # si erreurs, abandon :
        if ($notification->hasErrors()) {
            return false;
        }
        
        if ($validateOnly) {
            return false;
        }

        # tentative déplacement du fichier :
        if (move_uploaded_file($filePathFrom, $filePathTo)) {
            return true;
        } else {
            throw new \Exception("Call to move_uploaded_file() returned false.");
        }
    }
    
}
