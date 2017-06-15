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

/**
 * Console configura todo el proyecto luego de instalarlo
 * @author Lucas Sosa
 */
class Console {
    
    /**
     * Crea la clave única de la aplicación
     */
    public static function postInstall() {
        $dir = dirname(dirname(__FILE__));
        $keyfile = $dir . DIRECTORY_SEPARATOR . 'appkey.txt';
        
        $file = fopen($keyfile, 'w');
        fwrite($file, bin2hex(random_bytes(96)));
        fclose($file);
        
    }
}