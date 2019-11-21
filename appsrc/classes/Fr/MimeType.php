<?php
namespace Fr;

class MimeType {

    protected static $types = array(
        "html" => "text/html",
        "css" => "text/css",
        "js" => "text/javascript",
        "json" => "application/json",

        "xml" => "application/xml",
        "xslt" => "application/xslt+xml",
        "xsl" => "application/xslt+xml",
        "dtd" => "application/xml-dtd",
        "xhtml" => "application/xhtml+xml",
        "tei" => "application/tei+xml",
        "rnc" => "application/relax-ng-compact-syntax",

        "txt" => "text/plain",
        "rtf" => "application/rtf",
        "rtx" => "text/richtext",
        "pdf" => "application/pdf",

        "odt" => "application/vnd.oasis.opendocument.text",
        "odm" => "application/vnd.oasis.opendocument.text-master",
        "ott" => "application/vnd.oasis.opendocument.text-template",
        "ods" => "application/vnd.oasis.opendocument.spreadsheet",
        "odp" => "application/vnd.oasis.opendocument.presentation",

        "abw" => "application/x-abiword",

        "doc" => "application/msword",
        "dot" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "xlt" => "application/vnd.ms-excel",
        "xla" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "pot" => "application/vnd.ms-powerpoint",
        "pps" => "application/vnd.ms-powerpoint",
        "ppa" => "application/vnd.ms-powerpoint",
        "mdb" => "application/x-msaccess",
        "chm" => "application/vnd.ms-htmlhelp",
        "hlp" => "application/winhlp",

        "zip" => "application/zip",
        "bz" => "application/x-bzip",
        "bz2" => "application/x-bzip2",
        "rar" => "application/x-rar-compressed",
        "tar" => "application/x-tar",
        "gtar" => "application/x-gtar",
        "7z" => "application/x-7z-compressed",
        "cpio" => "application/x-cpio",
        "epub" => "application/epub+zip",
        "texinfo" => "application/x-texinfo",
        "latex" => "application/x-latex",
        "tex" => "application/x-tex",
        "tfm" => "application/x-tex-tfm",


        "jar" => "application/java-archive",
        "sh" => "application/x-sh",
        "csh" => "application/x-csh",


        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "gif" => "image/gif",
        //"ico" => "image/vnd.microsoft.icon",
        "ico" => "image/x-icon",
        "svg" => "image/svg+xml",
        "bmp" => "image/bmp",
        "tiff" => "image/tiff",
        "xif" => "image/vnd.xiff",

        "mpg" => "video/mpeg",
        "mpeg" => "video/mpeg",
        "mp4" => "video/mp4",
        "mp4" => "video/mp4",
        "mov" => "video/quicktime",
        "wmv" => "video/x-ms-wmv",
        "avi" => "video/x-msvideo",
        "f4v" => "video/x-f4v",
        "flv" => "video/x-flv",
        "h261" => "video/h261",
        "h263" => "video/h263",
        "h264" => "video/h264",
        "asf" => "video/x-ms-asf",
        "qt" => "video/quicktime",
        "ogx" => "application/ogg",
        "oga" => "audio/ogg",
        "ogg" => "audio/ogg",
        "ogv" => "video/ogg",

        "aac" => "audio/x-aac",
        "aif" => "audio/x-aiff",
        "mid" => "audio/midi",
        "mp3" => "audio/mpeg",
        "rm" => "application/vnd.rn-realmedia",
        "ram" => "audio/x-pn-realaudio",
        "rmp" => "audio/x-pn-realaudio-plugin",
        "wav" => "audio/x-wav",


        "bin" => "application/octet-stream",
        "torrent" => "application/x-bittorrent",
        "swf" => "application/x-shockwave-flash",
        "deb" => "application/x-debian-package",
        "dvi" => "application/x-dvi",
        "gnumeric" => "application/x-gnumeric",
        "kml" => "application/vnd.google-earth.kml+xml",
        "kmz" => "application/vnd.google-earth.kmz",
        "cab" => "application/vnd.ms-cab-compressed",
        "exe" => "application/x-msdownload",

        "ttf" => "application/x-font-ttf",
        "otf" => "application/x-font-otf",
        "pfa" => "application/x-font-type1",
        "psf" => "application/x-font-linux-psf",
        "woff" => "application/x-font-woff",


        "t" => "text/troff",
        "psd" => "image/vnd.adobe.photoshop",
        "opf" => "application/oebps-package+xml",
    );

    public static function getMimeType($path, $default = false) {
        $infos = pathinfo($path);
        if (isset($infos['extension'])) {
            $ext = strtolower($infos['extension']);
            if (isset(self::$types[$ext])) {
                return self::$types[$ext];
            }
        }
        return $default;
    }

}
