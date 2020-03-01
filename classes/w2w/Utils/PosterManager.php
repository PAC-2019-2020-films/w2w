<?php

namespace w2w\Utils;

use \w2w\Model\Movie;
use \w2w\Utils\Notification;
use \w2w\DAO\DAOFactory;

class PosterManager
{
 
    public const BASEPATH_CONFNAME = "IMG_PATH_MOVIES";
    protected $baseUrl = "/uploads/";
    protected $basePath = "uploads/";
    protected $overwrite = true;
    protected $ignoreExifNotAvailable = true; // not safe for prod
    
    protected $uploads = [];
    
    public function __construct()
    {
        if (! defined(self::BASEPATH_CONFNAME)) {
            throw new \Exception(sprintf("Upload directory constant not defined (define '%s' with a path in 'index.php').", self::BASEPATH_CONFNAME));
        }
        $this->basePath = constant(self::BASEPATH_CONFNAME);
        if (! is_dir($this->basePath)) {
            throw new \Exception(sprintf("Upload directory is not a directory ('%s').", $this->basePath));
        }
        if (! is_readable($this->basePath)) {
            throw new \Exception(sprintf("Upload directory is not readable ('%s').", $this->basePath));
        }
        if (! is_writable($this->basePath)) {
            throw new \Exception(sprintf("Upload directory is not writable ('%s').", $this->basePath));
        }
        $this->addUpload("thumbnail", "poster-file-thumbnail", "%s.jpg",        1048576);
        $this->addUpload("medium",    "poster-file-medium",    "%s-medium.jpg", 1048576);
        $this->addUpload("big",       "poster-file-big",       "%s-big.jpg",    1048576);
    }
    
    protected function addUpload($name, $inputFileName, $nameFormat, $maxSize)
    {
        $upload = new \stdClass();
        $upload->name = $name;
        $upload->inputFileName = $inputFileName;
        $upload->nameFormat = $nameFormat;
        $upload->maxSize = $maxSize;
        $this->uploads[] = $upload;
    }
    
    /**
     * Teste si'il y a tentative d'upload pour le fichier 'inputFileName' (= nom dans le formulaire html)
     */
    protected function hasInputFile($inputFileName)
    {
        if (isset($_FILES[$inputFileName]) && $_FILES[$inputFileName]["error"] != UPLOAD_ERR_NO_FILE) {
            return true;
        }
        return false;
    }
    
    /**
     * Effectue des vérifications sur le fichier à uploader
     */
    protected function checkInputFile($inputFileName, $inputFileMaxSize, Notification $notification)
    {
        $valid = true;
        # Les informations d'upload de PHP doivent être présentes :
        if (! isset($_FILES[$inputFileName])) {
            throw new \Exception("Bad poster file upload name (change file input name in html form).");
        }
        # Vérifications sur les informations d'upload de PHP :
        switch ($_FILES[$inputFileName]["error"]) {
            case UPLOAD_ERR_OK :
                break;
            case UPLOAD_ERR_INI_SIZE :
            case UPLOAD_ERR_FORM_SIZE :
                $valid = false;
                $notification->addError("Fichier trop volumineux.");
                break;
            case UPLOAD_ERR_PARTIAL :
                $valid = false;
                $notification->addError("Upload du ficher incomplet. Veuillez réessayer.");
                break;
            case UPLOAD_ERR_NO_FILE :
                $notification->addError("Pas de fichier d'upload reçu.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR :
                $valid = false;
                throw new \Exception("PHP upload error : Un dossier temporaire est manquant.");
            case UPLOAD_ERR_CANT_WRITE :
                $valid = false;
                throw new \Exception("PHP upload error : Échec de l'écriture du fichier sur le disque.");
            case UPLOAD_ERR_EXTENSION :
                $valid = false;
                throw new \Exception("PHP upload error : Une extension PHP a arrêté l'envoi de fichier.");
        }
        # Vérification personnelle de taille fichier :
        if ($inputFileMaxSize > 0) {
            if ($_FILES[$inputFileName]["size"] > $inputFileMaxSize) {
                $valid = false;
                $notification->addError(sprintf("Poster file too big (max : %0.1d Kb).", $inputFileMaxSize / 1024));
            }
        }
        # On vérifie le type de l'image (deux premiers octets, nombre magique...) :
        # ($_FILES['userfile']['type'] = simple mimetype fourni par client, pas fiable)
        if (function_exists("exif_imagetype")) {
            $filePath = $_FILES[$inputFileName]["tmp_name"];
            if (exif_imagetype($filePath) != IMAGETYPE_JPEG) {
                $valid = false;
                $notification->addError("Poster file not a valid jpg image.");
            }
        } else {
            # fonction indisponible, vérification impossible :
            if (! $this->ignoreExifNotAvailable) {
                throw new \Exception("Unable to check poster file type (no Exif extension).");
            }
        }
        return $valid;
    }
    
    /**
     * Effectue l'upload.
     * 
     * - lance une exception en cas d'erreur interne à l'application
     * - ajoute une erreur dans Notification pour des erreurs utilisateur
     */
    public function upload(Movie $movie, Notification $notification)
    {
        $poster = $movie->getPoster();
        $uploaded = 0;
        foreach ($this->uploads as $upload) {
            #  si il y a tentative d'upload... :
            if ($this->hasInputFile($upload->inputFileName)) {
                # vérification que "poster" est non nul (une seule fois suffit):
                if (! $poster) {
                    $notification->addError("Impossible d'uploader si la propriété 'poster' du film est nulle.");
                    return false;
                }
                # si le contenu de l'upload est valide :
                if ($this->checkInputFile($upload->inputFileName, $upload->maxSize, $notification)) {
                    # chemin vers emplacement temporaire :
                    $filePathFrom = $_FILES[$upload->inputFileName]["tmp_name"];
                    # chemin vers emplacement souhaité de l'image :
                    $filePathTo   = $this->basePath . sprintf($upload->nameFormat, $poster);
                    # Si fichier existe déjà, on peut écraser ? 
                    if (file_exists($filePathTo) && ! $this->overwrite) {
                        $notification->addError("Poster file with same name already exists and overwriting not allowed ({$upload->name}).");
                        continue;
                    }
                    # tentative déplacement du fichier :
                    if (move_uploaded_file($filePathFrom, $filePathTo)) {
                        $uploaded++;
                    } else {
                        throw new \Exception("Call to move_uploaded_file({$filePathFrom}, {$filePathTo})) for upload '{$upload->name}' returned false.");
                    }
                }
            }
        }
        return $uploaded;
    }
    
    
    
    /**
     * Renvoie tableau avec urls des fichiers dans /uploads/ non associés à un film.
     */
    public function orphanPosters()
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $movieDAO = $daoFactory->getMovieDAO();
        $movies = $movieDAO->findAll();
        $posters = [];
        foreach ($movies as $movie) {
            if ($poster = $movie->getPoster()) {
                $posters[$poster] = $movie;
            }
        }
        $orphans = [];
        $ignore = [".", ".."];
        if ($files = scandir($this->basePath)) {
            foreach ($files as $file) {
                if (in_array($file, $ignore)) {
                    continue;
                }
                $filePath = $this->basePath . DIRECTORY_SEPARATOR . $file;
                if (! is_file($filePath)) {
                    continue;
                }
                $poster = pathinfo($file, PATHINFO_FILENAME);
                if (($pos = strrpos($poster, "-big")) > 0) {
                    $poster = substr($poster, 0, $pos);
                }
                elseif (($pos = strrpos($poster, "-medium")) > 0) {
                    $poster = substr($poster, 0, $pos);
                }
                if (! isset($posters[$poster])) {
                    $orphans[] = $this->baseUrl . $file;
                }
            }
        }
        return $orphans;
    }
    
    /**
     * Renvoie tableau avec urls des affiches manquantes (le film existe mais pas l'affiche).
     */
    public function missingPosters()
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $movieDAO = $daoFactory->getMovieDAO();
        $movies = $movieDAO->findAll();
        $missing = [];
        foreach ($movies as $movie) {
            if ($poster = $movie->getPoster()) {
                $files = [$poster . ".jpg", $poster . "-big.jpg", $poster . "-medium.jpg"];
                foreach ($files as $file) {
                    $filePath = $this->basePath . $file;
                    if (! is_file($filePath)) {
                        $missing[] = $this->baseUrl . $file;
                    }
                }
            }
        }
        return $missing;
    }
        
    public function getThumbnailPath(Movie $movie)
    {
        if ($poster = $movie->getPoster()) {
            return sprintf("%s%s.jpg", $this->basePath, $poster);
        }
        return null;
    }

    public function getMediumPath(Movie $movie)
    {
        if ($poster = $movie->getPoster()) {
            return sprintf("%s%s-medium.jpg", $this->basePath, $poster);
        }
        return null;
    }

    public function getBigPath(Movie $movie)
    {
        if ($poster = $movie->getPoster()) {
            return sprintf("%s%s-big.jpg", $this->basePath, $poster);
        }
        return null;
    }

    public function getThumbnailSize(Movie $movie)
    {
        if ($path = $this->getThumbnailPath($movie)) {
            if (is_file($path)) {
                return filesize($path);
            }
        }
        return null;
    }
    
    public function getMediumSize(Movie $movie)
    {
        if ($path = $this->getMediumPath($movie)) {
            if (is_file($path)) {
                return filesize($path);
            }
        }
        return null;
    }
    
    public function getBigSize(Movie $movie)
    {
        if ($path = $this->getBigPath($movie)) {
            if (is_file($path)) {
                return filesize($path);
            }
        }
        return null;
    }
    
    protected function getImageDimension($path)
    {
        if (is_file($path) && is_readable($path)) {
            if ($img = imagecreatefromjpeg($path))  {
                $w = imagesx($img);
                $h = imagesy($img);
                imagedestroy($img);
                return sprintf("%dx%d", $w, $h);
            }
        }
        return null;
    }
    
    public function getThumbnailDimensions(Movie $movie)
    {
        if ($path = $this->getThumbnailPath($movie)) {
            return $this->getImageDimension($path);
        }
        return null;
    }
    
    public function getMediumDimensions(Movie $movie)
    {
        if ($path = $this->getMediumPath($movie)) {
            return $this->getImageDimension($path);
        }
        return null;
    }
    
    public function getBigDimensions(Movie $movie)
    {
        if ($path = $this->getBigPath($movie)) {
            return $this->getImageDimension($path);
        }
        return null;
    }
    
    
    
    public function deleteMoviePosters(Movie $movie)
    {
        if ($path = $this->getThumbnailPath($movie)) {
            if (is_file($path)) {
                unlink($path);
            }
        }
        if ($path = $this->getMediumPath($movie)) {
            if (is_file($path)) {
                unlink($path);
            }
        }
        if ($path = $this->getBigPath($movie)) {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

}
