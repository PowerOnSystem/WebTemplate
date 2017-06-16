<?php

/*
 * Copyright (C) Makuc Julian & Makuc Diego S.H.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace PowerOn\Console;
use Composer\Script\Event;
/**
 * Console configura todo el proyecto luego de instalarlo
 * @author Lucas Sosa
 */
class Console {
    
    /**
     * Crea la clave única de la aplicación
     */
    public static function postInstall(Event $event) {
        $dir = dirname(dirname(__FILE__));
        $dir_explode = explode(DIRECTORY_SEPARATOR, $dir);
        
        $app = end($dir_explode);
        
        $io = $event->getIO();
        
        $io->write('Generando clave de seguridad unica.');
        $keyfile = $dir . DIRECTORY_SEPARATOR . 'appkey.txt';
        
        $file = fopen($keyfile, 'w');
        fwrite($file, bin2hex(random_bytes(96)));
        fclose($file);
        
        $io->write('Configurando aplicacion.');
        
        self::createJsonFile($dir, $app, $io);
        
        
    }
    /**
     * Crea el archivo composer
     * @param string $dir
     * @param string $app Nombre de la aplicacion
     * @param IO $io
     */
    public static function createJsonFile($dir, $app, $io) {
        $composer_file = $dir . DIRECTORY_SEPARATOR . 'composer.json';
        $composer_lock = $dir . DIRECTORY_SEPARATOR . 'composer.lock';
        if ( file_exists($composer_file) ) {
            unlink($composer_file);
        }
        if (file_exists($composer_lock) ) {
            unlink($composer_lock);
        }
        
        $file = fopen($dir . DIRECTORY_SEPARATOR . 'composer.json', 'w');
        fwrite($file, 
            '{' . PHP_EOL .
                '\t"name": "poweronsystem/' . $app . '",' . PHP_EOL .
                '\t"type": "library",' . PHP_EOL .
                '\t"require": {' . PHP_EOL .
                    '"\t\tpoweronsystem/webframework": "^0.1.0"' . PHP_EOL .
                '\t}' . PHP_EOL .
            '}');
        fclose($file);
        
        $io->write('El archivo composer.json fue generado correctamente.');
    }
}