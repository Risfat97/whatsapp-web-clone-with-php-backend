<?php
namespace App\enums;

class EnumContentType {
    const TEXT = 'text';
    const IMAGE = 'image';
    const AUDIO = 'audio';
    const VIDEO = 'video';
    const PDF = 'pdf';

    public static function getValues(): array {
        return [
            self::TEXT,
            self::IMAGE,
            self::AUDIO,
            self::VIDEO,
            self::PDF
        ];
    }
}