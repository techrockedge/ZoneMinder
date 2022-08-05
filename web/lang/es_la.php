<?php
//
// ZoneMinder web Latam Spanish language file, $Date$, $Revision$
// Copyright (C) 2001-2008 Philip Coombes
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
//

// ZoneMinder Spanish 'la' Original Translation by Ovargaspcr. 
// Date Update - Responsible - Desc
// 30-06-2022       Ovargasp      Initial translation
// 07-07-2022       Ovargasp      Added most missing phrases from interface.
// 09-07-2022       Ovargasp      Added most 1.37.x phrases from interface.
// 13-07-2022       Ovargasp      Reformated to include prompts in OLANG array.



// Simple String Replacements
$SLANG = array(
    '24BitColour'          => 'Color 24 bits',
    '32BitColour'          => 'Color 32 bits',          // Added - 2011-06-15
    '8BitGrey'             => 'Grises 8 bits',
    'Action'               => 'Accion',
    'Actual'               => 'Normal 1X',
    'AddNewControl'        => 'Agregar Perfil Control PTZ',
    'AddNewMonitor'        => 'Agregar Monitor',
    'AddNewServer'         => 'Agregar Servidor',         // Added - 2018-08-30
    'AddNewStorage'        => 'Agregar Almacenamiento',        // Added - 2018-08-30
    'AddNewUser'           => 'Agregar Usuario',
    'AddNewZone'           => 'Agregar Zona',
    'Alarm'                => 'Alarma',
    'AlarmBrFrames'        => 'Cuadros<br/>Alarma',
    'AlarmFrame'           => 'Cuadro Alarma',
    'AlarmFrameCount'      => 'Conteo Cuadros Alarma',
    'AlarmLimits'          => 'Limites Alarma',
    'AlarmMaximumFPS'      => 'FPS Maximo Alarma',
    'AlarmPx'              => 'Px Alarma',
    'AlarmRGBUnset'        => 'Debe definir el color RGB de la alarma',
    'AlarmRefImageBlendPct'=> 'Referencia Mezcla Imagen Alarma %ge', // Added - 2015-04-18
    'Alert'                => 'Alerta',
    'All'                  => 'Todo',
    'AnalysisFPS'          => 'FPS para Analisis',           // Added - 2015-07-22
    'AnalysisUpdateDelay'  => 'Retardo Actualizacion Analisis',  // Added - 2015-07-23
    'Apply'                => 'Aplicar',
    'ApplyingStateChange'  => 'Aplicar Cambio Estado',
    'ArchArchived'         => 'Solo Archivados',
    'ArchUnarchived'       => 'Solo Sin Archivar',
    'Archive'              => 'Archivar',
    'Archived'             => 'Archivado',
    'Area'                 => 'Area',
    'AreaUnits'            => 'Area (px/%)',
    'AttrAlarmFrames'      => 'Cuadros Alarma',
    'AttrArchiveStatus'    => 'Estado Archivo',
    'AttrAvgScore'         => 'Puntaje Prom.',
    'AttrCause'            => 'Causa',
    'AttrDiskBlocks'       => 'Bloques Disco',
    'AttrDiskPercent'      => 'Procentaje Disco',
    'AttrDiskSpace'        => 'Espacio Disco',             // Added - 2018-08-30
    'AttrDuration'         => 'Duración',
    'AttrEndDate'          => 'Fecha Fin',               // Added - 2018-08-30
    'AttrEndDateTime'      => 'Fecha/Hora Fin',          // Added - 2018-08-30
    'AttrEndTime'          => 'Hora Fin',               // Added - 2018-08-30
    'AttrEndWeekday'       => 'Ultimo día semana',            // Added - 2018-08-30
    'AttrFilterServer'     => 'Filtro de Servidor esta ejecutandose', // Added - 2018-08-30
    'AttrFrames'           => 'Cuadros',
    'AttrId'               => 'Id',
    'AttrMaxScore'         => 'Puntaje Máximo',
    'AttrMonitorId'        => 'ID Monitor',
    'AttrMonitorName'      => 'Nombre Monitor',
    'AttrMonitorServer'    => 'Servidor Monitores esta corriendo', // Added - 2018-08-30
    'AttrName'             => 'Nombre',
    'AttrNotes'            => 'Notas',
    'AttrStartDate'        => 'Fecha Inicio',             // Added - 2018-08-30
    'AttrStartDateTime'    => 'Fecha/Hora Inicio',        // Added - 2018-08-30
    'AttrStartTime'        => 'Hora Inicio',             // Added - 2018-08-30
    'AttrStartWeekday'     => 'Primer día semana',          // Added - 2018-08-30
    'AttrStateId'          => 'Estado Corrida',              // Added - 2018-08-30
    'AttrStorageArea'      => 'Area Almacenamiento',           // Added - 2018-08-30
    'AttrStorageServer'    => 'Servidor Almacenamiento', // Added - 2018-08-30
    'AttrSystemLoad'       => 'Carga Sistema',
    'AttrTotalScore'       => 'Puntaje Total',
    'Auto'                 => 'Auto',
    'AutoStopTimeout'      => 'Auto Stop Timeout', // ******* ICON
    'Available'            => 'Disponible',              // Added - 2009-03-31
    'AvgBrScore'           => 'Puntaje<br/>Prom',
    'Background'           => 'Segundo Plano',
    'BackgroundFilter'     => 'Correr filtro en Segundo Plano',
    'BadAlarmFrameCount'   => 'Conteo cuadros de alarma debe ser entero mayor a uno',
    'BadAlarmMaxFPS'       => 'FPS Maximos Alarma debe ser un numero positivo',
    'BadAnalysisFPS'       => 'FPS de Analisis debe ser un numero positivo', // Added - 2015-07-22
    'BadAnalysisUpdateDelay'=> 'Retardo actualización Analisis debe ser un entero 0 o mayor', // Added - 2015-07-23
    'BadChannel'           => 'Canal debe ser un entero 0 o mayor',
    'BadColours'           => 'Color debe ser un valor valido', // Added - 2011-06-15
    'BadDevice'            => 'Dispositivo debe ser un valor valido',
    'BadFPSReportInterval' => 'Intervalo de reporte del conteo de FPS del buffer debe ser un entero 0 o mayor',
    'BadFormat'            => 'Formato debe ser un entero 0 o mayor', 
    'BadFrameSkip'         => 'Cuenta de Cuadros saltados debe ser un entero 0 o mayor',
    'BadHeight'            => 'Altura debe ser un valor valido',
    'BadHost'              => 'Host debe ser un nombre o una IP válida, no incluya el http://',
    'BadImageBufferCount'  => 'Tamaño del buffer de imagen debe ser un entero 2 o mayor',
    'BadLabelX'            => 'Coordenada X de la etiqueta debe ser un entero 0 o mayor',
    'BadLabelY'            => 'Coordenada Y de la etiqueta debe ser un entero 0 o mayor',
    'BadMaxFPS'            => 'FPS máximas debe ser un # entero o flotante positivo',
    'BadMotionFrameSkip'   => 'Salto de cuadro de movimiento debe ser un entero 0 o mayor',
    'BadNameChars'         => 'Los nombres pueden contener solamente caracteres alfanuméricos más el guión y la raya',
    'BadPalette'           => 'La paleta debe ser establecida a un valor válido', // Added - 2009-03-31
    'BadPath'              => 'La Ruta ser establecida a un valor válido',
    'BadPort'              => 'El Puerto ser establecido a un valor válido',
    'BadPostEventCount'    => 'Conteo de imagenes post evento debe ser un entero 0 o mayor',
    'BadPreEventCount'     => 'Conteo de imagenes pre evento debe ser al menos 0, y menor que el tamaño del Buffer de imagen',
    'BadRefBlendPerc'      => 'Porcentaje de referencia de mezcla debe ser un # entero positivo',  
    'BadSectionLength'     => 'Tamaño de la sección debe ser un entero 30 o mayor',
    'BadSignalCheckColour' => 'Color de chequeo de señal debe ser un string RGB valido',
    'BadSourceType'        => 'Tipo fuente \"Web Site\" requiere que la funcion sea \"Monitor\"', // Added - 2018-08-30
    'BadStreamReplayBuffer'=> 'Buffer de repetición debe ser un entero 0 o mayor',
    'BadWarmupCount'       => 'Cuadros de Calentamiento debe ser un entero 0 o mayor',
    'BadWebColour'         => 'Color WEB debe ser un string RGB valido',
    'BadWebSitePath'       => 'Ingrese un url completo, incluyendo el prefijo http:// ó https:// .', // Added - 2018-08-30
    'BadWidth'             => 'Ancho debe ser un valor válido',
    'Bandwidth'            => 'Ancho de Banda',
    'BandwidthHead'         => 'Ancho de Banda',	// This is the end of the bandwidth status on the top of the console, different in many language due to phrasing  
    'BlobPx'               => 'Blob Px',
    'BlobSizes'            => 'Tam. Blob',
    'Blobs'                => 'Blobs',
    'Brightness'           => 'Brillo',
    'Buffer'               => 'Buffer',                 // Added - 2015-04-18
    'Buffers'              => 'Buffers',
    'CSSDescription'       => 'Cambiar el css por defecto de este equipo', // Added - 2015-04-18
    'CanAutoFocus'         => 'Soporta Auto Focus',
    'CanAutoGain'          => 'Soporta Auto Gain',
    'CanAutoIris'          => 'Soporta Auto Iris',
    'CanAutoWhite'         => 'Soporta Auto White Bal.',
    'CanAutoZoom'          => 'Soporta Auto Zoom',
    'CanFocus'             => 'Soporta Focus',
    'CanFocusAbs'          => 'Soporta Focus Absoluto',
    'CanFocusCon'          => 'Soporta Focus Continuo',
    'CanFocusRel'          => 'Soporta Focus Relativo',
    'CanGain'              => 'Soporta Gain ',
    'CanGainAbs'           => 'Soporta Gain Absoluto',
    'CanGainCon'           => 'Soporta Gain Continuo',
    'CanGainRel'           => 'Soporta Gain Relativo',
    'CanIris'              => 'Soporta Iris',
    'CanIrisAbs'           => 'Soporta Iris Absoluto',
    'CanIrisCon'           => 'Soporta Iris Continuo',
    'CanIrisRel'           => 'Soporta Iris Relativo',
    'CanMove'              => 'Soporta Movimiento',
    'CanMoveAbs'           => 'Soporta Movimiento Absoluto',
    'CanMoveCon'           => 'Soporta Movimiento Continuo',
    'CanMoveDiag'          => 'Soporta Movimiento Diagonal',
    'CanMoveMap'           => 'Soporta Movimiento Mapeado',
    'CanMoveRel'           => 'Soporta Movimiento Relativo',
    'CanPan'               => 'Soporta Pan' ,
    'CanReset'             => 'Soporta Reset',
	'CanReboot'             => 'Soporta Reiniciar',
    'CanSetPresets'        => 'Soporta Establecer Presets',
    'CanSleep'             => 'Soporta Sleep',
    'CanTilt'              => 'Soporta Tilt',
    'CanWake'              => 'Soporta Wake',
    'CanWhite'             => 'Soporta White Balance',
    'CanWhiteAbs'          => 'Soporta White Bal. Absoluto',
    'CanWhiteBal'          => 'Soporta White Bal.',
    'CanWhiteCon'          => 'Soporta White Bal. Continuo',
    'CanWhiteRel'          => 'Soporta White Bal. Relativo',
    'CanZoom'              => 'Soporta Zoom',
    'CanZoomAbs'           => 'Soporta Zoom Absoluto',
    'CanZoomCon'           => 'Soporta Zoom Continuo',
    'CanZoomRel'           => 'Soporta Zoom Relativo',
    'Cancel'               => 'Cancelar',
    'CancelForcedAlarm'    => 'Cancelar Alarma Forzada',
    'CaptureHeight'        => 'Captura Altura',
    'CaptureMethod'        => 'Captura Metodo',         // Added - 2009-02-08
    'CapturePalette'       => 'Captura Paleta',
    'CaptureResolution'    => 'Resolucion Captura',     // Added - 2015-04-18
    'CaptureWidth'         => 'Captura Ancho',
    'Cause'                => 'Causa',  
    'CheckMethod'          => 'Metodo chequeo Alarma',
    'ChooseDetectedCamera' => 'Elegir Cámara detectada', // Added - 2009-03-31
    'ChooseFilter'         => 'Elegir Filtro',
    'ChooseLogFormat'      => 'Elegir formato log',    // Added - 2011-06-17
    'ChooseLogSelection'   => 'Elija una selección de log', // Added - 2011-06-17
    'ChoosePreset'         => 'Elegir Preset',
    'Clear'                => 'Limpiar',                  // Added - 2011-06-16
    'CloneMonitor'         => 'Clonar',                  // Added - 2018-08-30
    'Close'                => 'Cerrar',
    'Colour'               => 'Color',
    'Command'              => 'Comando',
    'Component'            => 'Componente',              // Added - 2011-06-16
    'ConcurrentFilter'     => 'Correr filtro concurrentemente', // Added - 2018-08-30
    'Config'           => 'Configuración',
    'ConfiguredFor'        => 'Configurado Para',
    'ConfirmDeleteEvents'  => 'Seguro que desea borrar los eventos seleccionados?',
    'ConfirmPassword'      => 'Confirmar Contraseña',
    'ConjAnd'              => 'y',
    'ConjOr'               => 'o',
    'Console'              => 'Consola', 
    'ContactAdmin'         => 'Contacte el Administrador para detalles.',
    'Continue'             => 'Continuar',
    'Contrast'             => 'Contraste',
    'Control'              => 'Control',
    'ControlAddress'       => 'URL de Control',
    'ControlCap'           => 'Capacidad Control',
    'ControlCaps'          => 'Capacidades Control',
    'ControlDevice'        => 'Dispositivo Control',
    'ControlType'          => 'Tipo de Control',
    'Controllable'         => 'Controlable',
    'Current'              => 'Actual',                // Added - 2015-04-18
    'Cycle'                => 'Ciclo',
    'CycleWatch'           => 'Vista de Ciclo',
    'DateTime'             => 'Fecha/Hora',              // Added - 2011-06-16
    'Day'                  => 'Día',
    'Debug'                => 'Debug',
    'DefaultRate'          => 'Tasa por Defecto',
    'DefaultScale'         => 'Escala por Defecto',
    'DefaultView'          => 'Vista por Defecto',
    'Deinterlacing'        => 'Desentrelazado',          // Added - 2015-04-18
    'Delay'                => 'Retardo',                  // Added - 2015-04-18
    'Delete'               => 'Borrar',
    'DeleteAndNext'        => 'Borrar &amp; Próximo',
    'DeleteAndPrev'        => 'Borrar &amp; Anterior',
    'DeleteSavedFilter'    => 'Borrar Filtro Guardado',
    'Description'          => 'Descripción',
    'DetectedCameras'      => 'Camaras Detectadas',       // Added - 2009-03-31
    'DetectedProfiles'     => 'Perfiles Detectados ',      // Added - 2015-04-18
    'Device'               => 'Dispositivo',                 // Added - 2009-02-08
    'DeviceChannel'        => 'Canal',
    'DeviceFormat'         => 'Señal',
    'DeviceNumber'         => 'Fuente',
    'DevicePath'           => 'Ruta Dispositivo',
    'Devices'              => 'Dispositivos',
    'Dimensions'           => 'Dimensiones',
    'DisableAlarms'        => 'Desactivar Alarmas',
    'Disk'                 => 'Disco',
    'Display'              => 'Diseño',                // Added - 2011-01-30
    'Displaying'           => 'Mostrando',             // Added - 2011-06-16       
    'DoNativeMotionDetection'=> 'Usar Detección Nativa de Mov.',
    'Donate'               => 'Por favor, Realice una donacion',
    'DonateAlready'        => 'No, ya he donado',
    'DonateEnticement'     => 'Ha estado ejecutando ZoneMinder durante un tiempo ya, y con suerte lo está encontrando como una adición útil a la seguridad de su hogar o lugar de trabajo. Aunque ZoneMinder es, y seguirá siendo, gratuito y de código abierto, cuesta dinero desarrollarlo y mantenerlo. Si desea ayudar a respaldar el desarrollo futuro y las nuevas funciones, considere hacer una donación. La donación es, por supuesto, opcional pero muy apreciada y puede donar tanto o tan poco como desee.<br><br>Si desea donar, seleccione la opción a continuación o vaya a https://zoneminder.com/donate/ en su navegador.<br><br>Gracias por usar ZoneMinder y no olvide visitar los foros en ZoneMinder.com para obtener ayuda o sugerencias sobre cómo mejorar aún más su experiencia con ZoneMinder.',
    'DonateRemindDay'      => 'No todavía, recordarme en 1 día',
    'DonateRemindHour'     => 'No todavía, recordarme en 1 hora',
    'DonateRemindMonth'    => 'No todavía, recordarme en 1 mes',
    'DonateRemindNever'    => 'No deseo donar, no recordar de nuevo',
    'DonateRemindWeek'     => 'No todavía, recordarme en 1 semana',
    'DonateYes'            => 'Si, quiero donar ahora',
    'Download'             => 'Descargar',
    'DownloadVideo'        => 'Descargar Video',         // Added - 2018-08-30
    'DuplicateMonitorName' => 'Duplicar nombre Monitor', // Added - 2009-03-31
    'Duration'             => 'Duración',
    'Edit'                 => 'Editar',
    'EditLayout'           => 'Editar Plantilla',            // Added - 2018-08-30
    'Email'                => 'Email',
    'EnableAlarms'         => 'Habilitar Alarmas',
    'Enabled'              => 'Habilitado',
    'EnterNewFilterName'   => 'Ingresar Nuevo Nombre De Filtro',
    'Error'                => 'Error',
    'ErrorBrackets'        => 'Error, Revisar si tiene la misma cantidad de paréntesis de apertura',
    'ErrorValidValue'      => 'Error, Revisar si los términos tienen nombres validos',
    'Etc'                  => 'etc',
    'Event'                => 'Evento',
    'EventFilter'          => 'Filtro de Evento',
    'EventId'              => 'ID Evento',
    'EventName'            => 'Nombre Evento',
    'EventPrefix'          => 'Prefijo Evento',
    'Events'               => 'Eventos',
    'Exclude'              => 'Excluir',
    'Execute'              => 'Ejecutar',
    'Exif'                 => 'Insertar datos EXIF en imagen', // Added - 2018-08-30
    'Export'               => 'Exportar',
    'ExportDetails'        => 'Exportar Detalles Evento',
    'ExportFailed'         => 'Falló Exportar',
    'ExportFormat'         => 'Formato Archivo Exportar',
    'ExportFormatTar'      => 'Tar',
    'ExportFormatZip'      => 'Zip',   
    'ExportFrames'         => 'Exportar Detalles Cuadro',
    'ExportImageFiles'     => 'Exportar arch. Imagen',
    'ExportLog'            => 'Exportar Logs',             // Added - 2011-06-17
    'ExportMiscFiles'      => 'Exportar otros arch. (si hay)',
    'ExportOptions'        => 'Exportar Opciones',
    'ExportSucceeded'      => 'Exportado correcto',       // Added - 2009-02-08
    'ExportVideoFiles'     => 'Exportar arch. Video (si hay)',
    'Exporting'            => 'Exportando',
    'FPS'                  => 'fps',
    'FPSReportInterval'    => 'Intervalo de Reporte FPS',
    'FTP'                  => 'FTP',
    'Far'                  => 'Lejos',
    'FastForward'          => 'Adelant. rápido',
    'Feed'                 => 'Vista',
    'Ffmpeg'               => 'Ffmpeg',                 // Added - 2009-02-08
    'File'                 => 'Archivo',
    'Filter'               => 'Filtro',                 // Added - 2015-04-18
    'FilterArchiveEvents'  => 'Archivar todas las coincidencias',
    'FilterDeleteEvents'   => 'Borrar todas las coincidencias',
    'FilterEmailEvents'    => 'Mandar un mail de los eventos',
    'FilterExecuteEvents'  => 'Ejecutar un comando en las coincidencias',
    'FilterLog'            => 'Filtrar log',             // Added - 2015-04-18
    'FilterMessageEvents'  => 'Mandar un mensaje de los eventos',
    'FilterMoveEvents'     => 'Mover todas las coincidencias',       // Added - 2018-08-30
    'FilterPx'             => 'Filtro Px',
    'FilterUnset'          => 'Debe especificar alto y ancho del filtro',
    'FilterUpdateDiskSpace'=> 'Actualizar espacio usado disco', // Added - 2018-08-30
    'FilterUploadEvents'   => 'Subir los eventos que coincidan',
    'FilterVideoEvents'    => 'Crear videos para todas las coincidencias',
    'Filters'              => 'Filtros',
    'First'                => 'Primero',
    'FlippedHori'          => 'Volteado Horizontalmente',
    'FlippedVert'          => 'Volteado Verticalmente',
    'FnMocord'              => 'Mocord',            // Added 2013.08.16.
    'FnModect'              => 'Modect',            // Added 2013.08.16.
    'FnMonitor'             => 'Monitor',            // Added 2013.08.16.
    'FnNodect'              => 'Nodect',            // Added 2013.08.16.
    'FnNone'                => 'None',            // Added 2013.08.16.
    'FnRecord'              => 'Record',            // Added 2013.08.16.
    'Focus'                => 'Focus',
    'ForceAlarm'           => 'Forzar Alarma',
    'Format'               => 'Formato',
    'Frame'                => 'Cuadro',
    'FrameId'              => 'Id Cuadro',
    'FrameRate'            => 'Velocidad del video',
    'FrameSkip'            => 'Saltar Cuadro',
    'Frames'               => 'Cuadros',
    'Func'                 => 'Func.',
    'Function'             => 'Función',
    'Gain'                 => 'Gain',
    'General'              => 'General',
    'GenerateDownload'     => 'Generar Descargable',      // Added - 2018-08-30
    'GenerateVideo'        => 'Crear Video',
    'GeneratingVideo'      => 'Creando Video',
    'GoToZoneMinder'       => 'Ir a Zoneminder.com',
    'Grey'                 => 'Gris',
    'Group'                => 'Grupo',
    'Groups'               => 'Grupos', 
    'HasFocusSpeed'        => 'Soporta Velocidad Focus',
    'HasGainSpeed'         => 'Soporta Velocidad Gain',
    'HasHomePreset'        => 'Soporta Preset inicio',
    'HasIrisSpeed'         => 'Soporta Velocidad Iris',
    'HasPanSpeed'          => 'Soporta Velocidad Pan',
    'HasPresets'           => 'Soporta Presets',
    'HasTiltSpeed'         => 'Soporta Velocidad Tilt',
    'HasTurboPan'          => 'Soporta Turbo Pan',
    'HasTurboTilt'         => 'Soporta Turbo Tilt',
    'HasWhiteSpeed'        => 'Soporta Velocidad White Bal.',
    'HasZoomSpeed'         => 'Soporta Velocidad Zoom',
    'High'                 => 'Alto A.B.',
    'HighBW'               => 'Alto&nbsp;A/B',
    'Home'                 => 'Inicio',
    'Hostname'             => 'Nombre Host',               // Added - 2018-08-30
    'Hour'                 => 'Hora',
    'Hue'                  => 'Saturación',
    'Id'                   => 'Id',
    'Idle'                 => 'Pasivo',
    'Ignore'               => 'Ignorar',
    'Image'                => 'Imagen',
    'ImageBufferSize'      => 'Tamaño del Buffer de Imagen (Cuadros)',
    'Images'               => 'Imagenes',
    'In'                   => 'In',
    'Include'              => 'Incluir',
    'Inverted'             => 'Invertido',
    'Iris'                 => 'Iris',
    'KeyString'            => 'Cadena Clave',
    'Label'                => 'Etiqueta',
    'Language'             => 'Lenguaje',
    'Last'                 => 'Ultimo',
    'Layout'               => 'Diseño',                 // Added - 2009-02-08
    'Level'                => 'Nivel',                  // Added - 2011-06-16
    'Libvlc'               => 'Libvlc',
    'LimitResultsPost'     => 'Resultados;', // This is used at the end of the phrase 'Limit to first N results only'
    'LimitResultsPre'      => 'Solo los primeros', // This is used at the beginning of the phrase 'Limit to first N results only'
    'Line'                 => 'Linea',                   // Added - 2011-06-16
    'LinkedMonitors'       => 'Monitores Asociados',
    'List'                 => 'Listar',
    'ListMatches'          => 'Listar coincidencias',           // Added - 2018-08-30
    'Load'                 => 'Carga sistema',
    'Local'                => 'Local',
    'Log'                  => 'Log',                    // Added - 2011-06-16
    'LoggedInAs'           => 'Registrado Como',
    'Logging'              => 'Logging',                // Added - 2011-06-16
    'LoggingIn'            => 'Ingresando',
    'Login'                => 'Ingresar',
    'Logout'               => 'Salir',
    'Logs'                 => 'Logs',                   // Added - 2011-06-17
    'Low'                  => 'Bajo A.B.',
    'LowBW'                => 'Bajo&nbsp;A/B',
    'Main'                 => 'Principal',
    'Man'                  => 'Manual',
    'Manual'               => 'Manual',
    'Mark'                 => 'Marcar',
    'Max'                  => 'Max',
    'MaxBandwidth'         => 'A/B Max.',
    'MaxBrScore'           => 'Puntaje<br/>Max.',
    'MaxFocusRange'        => 'Rango Max Focus',
    'MaxFocusSpeed'        => 'Velocidad Max Focus',
    'MaxFocusStep'         => 'Paso Max Focus',
    'MaxGainRange'         => 'Rango Max Gain',
    'MaxGainSpeed'         => 'Velocidad Max Gain',
    'MaxGainStep'          => 'Paso Max Gain',
    'MaxIrisRange'         => 'Rango Max Iris',
    'MaxIrisSpeed'         => 'Velocidad Max Iris',
    'MaxIrisStep'          => 'Paso Max Iris',
    'MaxPanRange'          => 'Rango Max Pan',
    'MaxPanSpeed'          => 'Velocidad Max Pan',
    'MaxPanStep'           => 'Paso Max Pan',
    'MaxTiltRange'         => 'Rango Max Tilt',
    'MaxTiltSpeed'         => 'Velocidad Max Tilt',
    'MaxTiltStep'          => 'Paso Max Tilt',
    'MaxWhiteRange'        => 'Rango Max White Bal.',
    'MaxWhiteSpeed'        => 'Velocidad Max White Bal.',
    'MaxWhiteStep'         => 'Paso Max White Bal.',
    'MaxZoomRange'         => 'Rango Max Zoom',
    'MaxZoomSpeed'         => 'Velocidad Max Zoom',
    'MaxZoomStep'          => 'Paso Max Zoom',
    'MaximumFPS'           => 'FPS Máximo',
    'Medium'               => 'Medio A.B.',
    'MediumBW'             => 'Medio&nbsp;A/B',
    'Message'              => 'Mensaje',                // Added - 2011-06-16      
    'MinAlarmAreaLtMax'    => 'Area min de alarma debe ser menor que la max',
    'MinAlarmAreaUnset'    => 'Debe especificar la cuenta min de pixeles de alarma',
    'MinBlobAreaLtMax'     => 'Area min del Blob debe ser menor que la max',
    'MinBlobAreaUnset'     => 'Debe especificar la cuenta min de pixeles del blob',
    'MinBlobLtMinFilter'   => 'Area min del Blob debe ser menor o igual al area min del filtro',
    'MinBlobsLtMax'        => 'Valor min de blobs debe ser menor que el max',
    'MinBlobsUnset'        => 'Debe especificar la cuenta min de blobs',
    'MinFilterAreaLtMax'   => 'Area min del filtro debe ser menor que la max',
    'MinFilterAreaUnset'   => 'Debe especificar la cuenta min de pixeles del filtro',
    'MinFilterLtMinAlarm'  => 'Area min del filtro debe ser menor o igual al area min de la alarma',
    'MinFocusRange'        => 'Rango Min Focus',
    'MinFocusSpeed'        => 'Velocidad Min Focus',
    'MinFocusStep'         => 'Paso Min Focus',
    'MinGainRange'         => 'Rango Min Gain',
    'MinGainSpeed'         => 'Velocidad Min Gain',
    'MinGainStep'          => 'Paso Min Gain',
    'MinIrisRange'         => 'Rango Min Iris',
    'MinIrisSpeed'         => 'Velocidad Min Iris',
    'MinIrisStep'          => 'Paso Min Iris',
    'MinPanRange'          => 'Rango Min Pan',
    'MinPanSpeed'          => 'Velocidad Min Pan',
    'MinPanStep'           => 'Paso Min Pan',
    'MinPixelThresLtMax'   => 'Umbral min de pixels debe ser menor que el max',
    'MinPixelThresUnset'   => 'Debe especificar umbral min de pixeles',
    'MinTiltRange'         => 'Rango Min Tilt',
    'MinTiltSpeed'         => 'Velocidad Min Tilt',
    'MinTiltStep'          => 'Paso Min Tilt',
    'MinWhiteRange'        => 'Rango Min White Bal.',
    'MinWhiteSpeed'        => 'Velocidad Min White Bal.',
    'MinWhiteStep'         => 'Paso Min White Bal.',
    'MinZoomRange'         => 'Rango Min Zoom',
    'MinZoomSpeed'         => 'Velocidad Min Zoom',
    'MinZoomStep'          => 'Paso Min Zoom',
    'Misc'                 => 'Otros',
    'Mode'                 => 'Modo',                   // Added - 2015-04-18
    'Monitor'              => 'Monitor',
    'MonitorIds'           => 'Ids&nbsp;Monitor',
    'MonitorPreset'        => 'Preset Monitor',  
    'MonitorPresetIntro'   => 'Seleccione un preajuste apropiado de la lista a continuación.<br><br>Tenga en cuenta que esto puede sobrescribir cualquier valor que ya haya configurado para este monitor.<br><br>',
    'MonitorProbe'         => 'Resultado sondeo Monitores ',          // Added - 2009-03-31
    'MonitorProbeIntro'    => 'La siguiente lista muestra las cámaras analógicas y de red detectadas y si ya se están utilizando o están disponibles para su selección.<br/><br/>Seleccione la entrada deseada de la lista siguiente.<br/><br/>Tenga en cuenta que es posible que no se detecten todas las cámaras y que elegir una cámara de la lista puede sobrescribir cualquier valor que ya haya configurado para el monitor ya existente.<br/><br/>', // Added - 2009-03-31
    'Monitors'             => 'Monitores',
    'Montage'              => 'Muro Video',
    'MontageReview'        => 'Muro Video Historico',         // Added - 2018-08-30
    'Month'                => 'Mes',
    'More'                 => 'Mas',                   // Added - 2011-06-16
    'MotionFrameSkip'      => 'Salto de Cuadro Movimiento',
    'Move'                 => 'Mover',
    'Mtg2widgrd'           => 'cuadric. ancho 2',              // Added 2013.08.15.
    'Mtg3widgrd'           => 'cuadric. ancho 3',              // Added 2013.08.15. 
    'Mtg3widgrx'           => 'cuadric. ancho 3, ajustada, ampliar si alarma',              // Added 2013.08.15.
    'Mtg4widgrd'           => 'cuadric. ancho 4',              // Added 2013.08.15.
    'MtgDefault'           => 'Default',              // Added 2013.08.15.
    'MustBeGe'             => 'Debe ser mayor o igual que',
    'MustBeLe'             => 'Debe ser menor o igual que',
    'MustConfirmPassword'  => 'Debe confirmar la contraseña',
    'MustSupplyPassword'   => 'Debe ingresar una contraseña',
    'MustSupplyUsername'   => 'Debe ingresar un usuario', // Added - 2009-02-08
    'Name'                 => 'Nombre',
    'Near'                 => 'Cerca',
    'Network'              => 'Config. Red',
    'New'                  => 'Nuevo',
    'NewGroup'             => 'Nuevo Grupo',
    'NewLabel'             => 'Nueva Etiqueta',
    'NewPassword'          => 'Nueva Contraseña',
    'NewState'             => 'Nuevo Estado',
    'NewUser'              => 'Nuevo Usuario',
    'Next'                 => 'Siguiente',
    'No'                   => 'No',
    'NoDetectedCameras'    => 'No se detectaron Camaras',    // Added - 2009-03-31
    'NoDetectedProfiles'   => 'No se detectaron Profiles',   // Added - 2018-08-30
    'NoFramesRecorded'     => 'No hay movimientos grabados para este evento',
    'NoGroup'              => 'Sin Grupo',
    'NoSavedFilters'       => 'Filtros No Guardados',
    'NoStatisticsRecorded' => 'No hay estadisticas guardadas para este evento/marco',
    'None'                 => 'Ninguno',
    'NoneAvailable'        => 'Ninguno Disponible',
    'Normal'               => 'Normal',
    'Notes'                => 'Notas',
    'NumPresets'           => 'Numero Presets',
    'Off'                  => 'Apa.',
    'On'                   => 'Enc.',
    'OnvifCredentialsIntro'=> 'Proporcione el nombre de usuario y la contraseña para la cámara seleccionada.<br/>Si no se ha creado ningún usuario para la cámara, el usuario proporcionado aquí se creará con la contraseña dada.<br/><br/>', // Added - 2015-04-18
    'OnvifProbe'           => 'Sonda ONVIF',                  // Added - 2015-04-18
    'OnvifProbeIntro'      => 'La siguiente lista muestra las cámaras ONVIF detectadas y si ya se están utilizando o están disponibles para su selección.<br/><br/>Seleccione la entrada deseada de la lista siguiente.<br/><br/>Tenga en cuenta que todas las cámaras puede no ser detectadas y que elegir una cámara aquí puede sobrescribir cualquier valor que ya haya configurado para el monitor existente.<br/><br/>', // Added - 2015-04-18
    'OpEq'                 => 'igual que',
    'OpGt'                 => 'mayor que',
    'OpGtEq'               => 'mayor o igual que',
    'OpIn'                 => 'En sistema',
    'OpIs'                 => 'es',                     // Added - 2018-08-30
    'OpIsNot'              => 'no es',                 // Added - 2018-08-30
    'OpLt'                 => 'menor que',
    'OpLtEq'               => 'menor o igual que',
    'OpMatches'            => 'Coincide',
    'OpNe'                 => 'distinto que',
    'OpNotIn'              => 'No en sistema',
    'OpNotMatches'         => 'No coincide',
    'Open'                 => 'Abierto',
    'OptionHelp'           => 'Ayuda',
    'OptionRestartWarning' => 'Estos cambios no se guardaran completamente\nmientras el sistema se ejecute. Cuando termine\nde realizar los cambios asegurese de\nreiniciar Zoneminder.',
    'OptionalEncoderParam' => 'Parametros optionales Encoder', // Added - 2018-08-30
    'Options'              => 'Opciones',
    'OrEnterNewName'       => 'o agregue nombre',
    'Order'                => 'Orden',
    'Orientation'          => 'Orientación',
    'Out'                  => 'Sal.',
    'OverwriteExisting'    => 'Sobreescribir Existente',
    'Paged'                => 'Paginado',
    'Pan'                  => 'Pan',
    'PanLeft'              => 'Pan Izq.',
    'PanRight'             => 'Pan Der.',
    'PanTilt'              => 'Pan/Tilt',
    'Parameter'            => 'Parametro',
    'Password'             => 'Contraseña',
    'PasswordsDifferent'   => 'Las contraseñas nueva y de confirmacion son diferentes',
    'Paths'                => 'Enlaces',
    'Pause'                => 'Pausa',
    'Phone'                => 'Tel.',
    'PhoneBW'              => 'Tel.&nbsp;B/N',
    'Pid'                  => 'PID',                    // Added - 2011-06-16   
    'PixelDiff'            => 'Dif. Pixel',             // Added - 2009-02-08
    'Pixels'               => 'pixels',
    'Play'                 => 'Reproducir',
    'PlayAll'              => 'Reprod.Todo',
    'PleaseWait'           => 'Espere por favor',
    'Plugins'              => 'Plugins',
    'Point'                => 'Punto',
    'PostEventImageBuffer' => 'Buffer Imagenes despues evento',
    'PreEventImageBuffer'  => 'Buffer Imagenes antes evento',
    'PreserveAspect'       => 'Conservar Relación Aspecto',
    'Preset'               => 'Preset',
    'Presets'              => 'Presets',
    'Prev'                 => 'Ant.',
    'Probe'                => 'Sonda Analoga',                  // Added - 2009-03-31
    'ProfileProbe'         => 'Sonda de Profiles',           // Added - 2015-04-18    
    'ProfileProbeIntro'    => 'La siguiente lista muestra los perfiles de transmisión existentes de la cámara seleccionada.<br/><br/>Seleccione la entrada deseada de la lista siguiente.<br/><br/>Tenga en cuenta que ZoneMinder no puede configurar perfiles adicionales y que elegir un cámara aquí puede sobrescribir cualquier valor que ya haya configurado para el monitor existente.<br/><br/>', // Added - 2015-04-18
    'Progress'             => 'Progreso',               // Added - 2015-04-18
    'Protocol'             => 'Protocolo',
    'RTSPDescribe'         => 'Use el URL de RTSP', // Added - 2018-08-30
    'RTSPTransport'        => 'Protocolo Transp. RTSP', // Added - 2018-08-30
    'Rate'                 => 'Tasa',
    'Real'                 => 'Real',
    'RecaptchaWarning'     => 'Su clave secreta de reCaptcha no es válida. Corríjala o reCaptcha no funcionará', // Added - 2018-08-30
    'Record'               => 'Registro',
    'RecordAudio'          => 'Almacenar audio al guardar el evento.', // Added - 2018-08-30
    'RefImageBlendPct'     => 'Mezcla Imagen de Referencia %ge',
    'Refresh'              => 'Actualizar',
    'Remote'               => 'Remoto',
    'RemoteHostName'       => 'Nombre Servidor Remoto',
    'RemoteHostPath'       => 'Path Servidor Remoto',
    'RemoteHostPort'       => 'Puerto Servidor Remoto',  
    'RemoteHostSubPath'    => 'SubPath para Host Remoto',    // Added - 2009-02-08
    'RemoteImageColours'   => 'Colores Imagen Remoto',
    'RemoteMethod'         => 'Metodo Remoto',          // Added - 2009-02-08
    'RemoteProtocol'       => 'Protocolo Remoto',        // Added - 2009-02-08
    'Rename'               => 'Renombrar',
    'Replay'               => 'Repetir',
    'ReplayAll'            => 'Todos los eventos',
    'ReplayGapless'        => 'Eventos sin brecha',
    'ReplaySingle'         => 'Evento unico',
    'ReportEventAudit'     => 'Reporte Eventos Audit. ',    // Added - 2018-08-30
    'Reset'                => 'Reset',
    'ResetEventCounts'     => 'Borrar Contador Eventos',
    'Restart'              => 'Reiniciar',
    'Restarting'           => 'Reiniciando',
    'RestrictedCameraIds'  => 'Ids. Camara restringidos',
    'RestrictedMonitors'   => 'Monitores Restringidos',
    'ReturnDelay'          => 'Obtener Delay',
    'ReturnLocation'       => 'Obtener ubicacion',
    'Rewind'               => 'Rebobinar',
    'RotateLeft'           => 'Rotar a la derecha',
    'RotateRight'          => 'Rotar a la izquierda',
    'RunLocalUpdate'       => 'Ejecute zmupdate.pl to actualizar', // Added - 2011-05-25
    'RunMode'              => 'Metodo Ejecucion',
    'RunState'             => 'Estado de Ejecución',
    'Running'              => 'Ejecutando',
    'Save'                 => 'Guardar',
    'SaveAs'               => 'Guardar Como',
    'SaveFilter'           => 'Guardar Filtro',
    'SaveJPEGs'            => 'Guardar JPEGs',             // Added - 2018-08-30
    'Scale'                => 'Escala',
    'Score'                => 'Res.',
    'Secs'                 => 'Segs',
    'Sectionlength'        => 'Longitud Sección',
    'Select'               => 'Seleccion',
    'SelectFormat'         => 'Selec. Formato',          // Added - 2011-06-17
    'SelectLog'            => 'Selec. Log',             // Added - 2011-06-17
    'SelectMonitors'       => 'Selec. Monitores',
    'SelfIntersecting'     => 'Bordes de los Poligonos no deben intersecarse',
    'Set'                  => 'Asig.',
    'SetNewBandwidth'      => 'Establecer Nuevo Ancho Banda',
    'SetPreset'            => 'Asig. Preset',
    'Settings'             => 'Configuracion',
    'ShowFilterWindow'     => 'Abrir ventana Filtro',
    'ShowTimeline'         => 'Mostrar linea tiempo',
    'SignalCheckColour'    => 'Color chequeo señal',
    'SignalCheckPoints'    => 'Puntos chequeo señal',    // Added - 2018-08-30
    'Size'                 => 'Tam.',   
    'SkinDescription'      => 'Cambiar el esquema web predeterminado para este equipo', // Added - 2011-01-30
    'Sleep'                => 'Sleep',
    'SortAsc'              => 'Asc',
    'SortBy'               => 'Ordenar por',
    'SortDesc'             => 'Desc',
    'Source'               => 'Origen',
    'SourceColours'        => 'Colores Origen',         // Added - 2009-02-08
    'SourcePath'           => 'Path Origen',            // Added - 2009-02-08
    'SourceType'           => 'Tipo Origen',
    'Speed'                => 'Vel.',
    'SpeedHigh'            => 'Alta Vel.',
    'SpeedLow'             => 'Baja Vel.',
    'SpeedMedium'          => 'Vel. Media',
    'SpeedTurbo'           => 'Vel. Turbo',
    'Start'                => 'Iniciar',
    'State'                => 'Estado',
    'Stats'                => 'Estadist.',
    'Status'               => 'Estatus',
    'StatusConnected'      => 'Capturando',              // Added - 2018-08-30
    'StatusNotRunning'     => 'Detenido',            // Added - 2018-08-30
    'StatusRunning'        => 'No Capturando',          // Added - 2018-08-30
    'StatusUnknown'        => 'Desconocido',                // Added - 2018-08-30
    'Step'                 => 'Paso',
    'StepBack'             => 'Paso Atras',
    'StepForward'          => 'Paso Adel.',
    'StepLarge'            => 'Paso Larg.',
    'StepMedium'           => 'Paso Med.',
    'StepNone'             => 'No Paso',
    'StepSmall'            => 'Paso Peq.',
    'Stills'               => 'Cuadros',
    'Stop'                 => 'Desactivar',
    'Stopped'              => 'Apagado',
    'StorageArea'          => 'Area Almac.',           // Added - 2018-08-30
    'StorageScheme'        => 'Esquema Almac.',                 // Added - 2018-08-30
    'Stream'               => 'Video',
    'StreamReplayBuffer'   => 'Buffer de Repeticion Stream',
    'Submit'               => 'Enviar',
    'System'               => 'Sistema',
    'SystemLog'            => 'Log sistema',             // Added - 2011-06-16
    'TargetColorspace'     => 'Profundidad color origen',      // Added - 2015-04-18
    'Tele'                 => 'Tele',
    'Thumbnail'            => 'Miniatura',
    'Tilt'                 => 'Tilt',
    'Time'                 => 'Hora',
    'TimeDelta'            => 'Delta Tiempo',
    'TimeStamp'            => 'Etiq. Tiempo',
    'Timeline'             => 'Linea tiempo',
    'TimelineTip1'         => 'Ubique el mouse sobre el algun punto del gráfico para ver una instantánea y los detalles del evento.',              // Added 2013.08.15.
    'TimelineTip2'         => 'Haga clic en las secciones coloreadas del gráfico, o en la imagen, para ver el evento.',              // Added 2013.08.15.
    'TimelineTip3'         => 'Haga clic en el background para ajustar a un período de tiempo más pequeño en función de su selección.',              // Added 2013.08.15.
    'TimelineTip4'         => 'Use los controles para navegar hacia atrás y hacia adelante a través del rango de tiempo.',              // Added 2013.08.15.
    'Timestamp'            => 'Etiqueta',
    'TimestampLabelFormat' => 'Formato Etiqueta Hora',
    'TimestampLabelSize'   => 'Tam. Fuente',              // Added - 2018-08-30
    'TimestampLabelX'      => 'Eje X Etiqueta Hora',
    'TimestampLabelY'      => 'Eje Y Etiqueta Hora',
    'Today'                => 'Hoy',
    'Tools'                => 'Herram.',
    'Total'                => 'Total',                  // Added - 2011-06-16
    'TotalBrScore'         => 'Punt.<br/>total',
    'TrackDelay'           => 'Retardo Pista',
    'TrackMotion'          => 'Mov. Pista',
    'Triggers'             => 'Triggers',
    'TurboPanSpeed'        => 'Vel. Turbo Pan',
    'TurboTiltSpeed'       => 'Vel. Turbo Tilt',
    'Type'                 => 'Tipo',
    'Unarchive'            => 'Desarchivar',
    'Undefined'            => 'Indef.',              // Added - 2009-02-08
    'Units'                => 'Unidades',
    'Unknown'              => 'Desconocido',
    'Update'               => 'Actualizar',
    'UpdateAvailable'      => 'Una Actualización a ZoneMinder esta disponible',
    'UpdateNotNecessary'   => 'No se requiere Actualización',
    'Updated'              => 'Actualizado',                // Added - 2011-06-16
    'Upload'               => 'Srv. Arch.',                 // Added - 2011-08-23
    'UseFilter'            => 'Usar Filtro',
    'UseFilterExprsPost'   => '&nbsp;filtrar&nbsp;sentencias', // This is used at the end of the phrase 'use N filter expressions'
    'UseFilterExprsPre'    => 'Utilizar&nbsp;', // This is used at the beginning of the phrase 'use N filter expressions'
    'UsedPlugins'	   => 'Plugins util.',
    'User'                 => 'Usuario',
    'Username'             => 'Nombre Usuario',
    'Users'                => 'Usuarios',
    'V4L'                  => 'V4L',                    // Added - 2015-04-18
    'V4LCapturesPerFrame'  => 'Capturas por Cuadro',     // Added - 2015-04-18
    'V4LMultiBuffer'       => 'Multi Buffering',        // Added - 2015-04-18
    'Value'                => 'Valor',
    'Version'              => 'Versión',
    'VersionIgnore'        => 'Ignore esta versión',
    'VersionRemindDay'     => 'Recordar en 1 día',
    'VersionRemindHour'    => 'Recordar en 1 hora',
    'VersionRemindNever'   => 'No avisar de nuevas versiones',
    'VersionRemindWeek'    => 'Recordar en 1 semana',
    'Video'                => 'Video',
    'VideoFormat'          => 'Formato Vid.',
    'VideoGenFailed'       => 'Fallo la creacion del video!',
    'VideoGenFiles'        => 'Archivos vid. existentes',
    'VideoGenNoFiles'      => 'No hay arch. video',
    'VideoGenParms'        => 'Parametros Generacion Video',
    'VideoGenSucceeded'    => 'Generacion Vid. Exitosa!',
    'VideoSize'            => 'Tamaño Video',
    'VideoWriter'          => 'Escritor Video',           // Added - 2018-08-30
    'View'                 => 'Ver',
    'ViewAll'              => 'Ver Todo',
    'ViewEvent'            => 'Ver Evento',
    'ViewPaged'            => 'Ver Paginado',
    'Wake'                 => 'Wake',
    'WarmupFrames'         => 'Cuadros calent.',
    'Watch'                => 'Monitor',
    'Web'                  => 'Web',
    'WebColour'            => 'Color Web',
    'WebSiteUrl'           => 'URL sitio',            // Added - 2018-08-30
    'Week'                 => 'Semana',
    'White'                => 'Blanco',
    'WhiteBalance'         => 'Balance Blancos',
    'Wide'                 => 'Ancho',
    'X'                    => 'X',
    'X10'                  => 'X10',
    'X10ActivationString'  => 'X10 Comando Activación',
    'X10InputAlarmString'  => 'X10 Comando Entrada Alarma',
    'X10OutputAlarmString' => 'X10 Output Alarm String',
    'Y'                    => 'Y',
    'Yes'                  => 'Si',
    'YouNoPerms'           => 'No tiene permisos para acceder a este recurso.',
    'Zone'                 => 'Zona',
    'ZoneAlarmColour'      => 'Color Alarma (Red/Green/Blue)',
    'ZoneArea'             => 'Area Zona',
    'ZoneExtendAlarmFrames' => 'Extender el conteo de cuadros de Alarma',
    'ZoneFilterSize'       => 'Alto/Ancho Filtro(pixels)',
    'ZoneMinMaxAlarmArea'  => 'Area Alarmada Min/Max',
    'ZoneMinMaxBlobArea'   => 'Area Blob Min/Max',
    'ZoneMinMaxBlobs'      => 'Blobs Min/Max',
    'ZoneMinMaxFiltArea'   => 'Area Filtrada Min/Max',
    'ZoneMinMaxPixelThres' => 'Umbral Pixel Min/Max (0-255)',
    'ZoneMinderLog'        => 'Log ZoneMinder',         // Added - 2011-06-17
    'ZoneOverloadFrames'   => 'Overload Frame Ignore Count', // ******* ICON
    'Zones'                => 'Zonas',
    'Zoom'                 => 'Zoom',
    'ZoomIn'               => 'Zoom In',
    'ZoomOut'              => 'Zoom Out',
// *********07-2022************************************ 
    'Storage'		   => 'Almacenamiento',
    'Back'                 => 'Regresar',
    'ParentGroup'          => 'Grupo Padre',
    'FilterUnarchiveEvents' => 'Desarchivar todas las coincidencias',
    'FilterCopyEvents'     => 'Copiar todas las coincidencias',
    'ViewMatches'          => 'Ver coinciencias',
    'ExportMatches'        => 'Exportar coincidencias',
    'FilterLockRows'       => 'Bloquear Filas',
    'OpLike'               => 'Contiene',
    'OpNotLike'            => 'No contiene',
    'Width'                => 'Ancho',
    'Height'               => 'Alto',
    'PreviousMonitor'      => 'Monitor Anterior',
    'PauseCycle'           => 'Pausar Ciclo',
    'PlayCycle'            => 'Iniciar Ciclo',
    'NextMonitor'          => 'Monitor Siguiente',
    'Server'               => 'Servidor',
    'Servers'               => 'Servidores',
    'DiskSpace'            => 'Espacio en Disco',
    'using'                => 'utilizando',
    'of'                   => 'de',
    'EditControl'          => 'Editar Control',
    'Privacy'              => 'Privacidad',
    'APIEnabled'           => 'API habilitado',
    'RevokeAllTokens'      => 'Revocar Todos los Tokens',
    'Revoke Token'         => 'Revocar Token',
    'API Enabled'           => 'API habilitado',
    'CpuLoad'              => 'Carga CPU',
    'Actions'              => 'Acciones',
    '8 Hour'               => '8 Horas',
    '1 Hour'               => '1 Hora',
    'Scale'                => 'Escala', // Montage Review -> type button
    'All Events'           => 'Todos Eventos',
//    'HISTORY'              => 'Historial', // Montage Review -> type button -> js
    'Archive Status'       => 'Estatus Archivado', // Montage Review -> type label
//    'Live'                 => 'En vivo', // Montage Review -> type button -> js
    'Download Video'       => 'Descargar Video',
//    '2 Wide'               => '2 Columnas', // Montage -> type Dropdown menu
    'Show Zones'           => 'Mostrar Zonas',
    'Hide Zones'           => 'Ocultar Zonas',
    'FirstEvent'           => 'Primer Evento',
    'LastEvent'            => 'Ultimo Evento',
    'MissingFiles'         => 'Arch Perdidos',
    'ZeroSize'             => 'Tam. Cero',
    'MinGap'               => 'Brecha Min',
    'MaxGap'               => 'Brecha Max',
    'Event Start Time'     => 'Tiempo Inicio Evento', 
    'to'                   => 'hasta',
    'Accept'               => 'Aceptar',
    'Decline'              => 'No Aceptar',
    'Analysis Enabled'     => 'Analisis Activo',
    'Importance'           => 'Importancia',
    'DefaultCodec'         => 'Codec por Defecto para "en vivo"',
    'RTSPServer'           => 'Servidor RTSP',
    'RTSPStreamName'       => 'Nombre del Stream RTSP',
    'MinSectionlength'     => 'Longitud Min Sección.',
    'seconds'              => 'segundos',
    'frames'               => 'cuadros',
    'Latitude'             => 'Latitud',
    'Longitude'            => 'Longitud',
    'GetCurrentLocation'   => 'Obtener ubicación',
    'Location'             => 'Ubicación',
    'ModectDuringPTZ'      => 'Detectar durante movimiento',
    'SourceSecondPath'     => 'Path Secundario Origen',
    'DecoderHWAccelName'   => 'Nombre tipo acelerador decodificacion',
    'DecoderHWAccelDevice' => 'Nombre Dispositivo acelerador decodificacion',
    'MaxImageBufferCount'  => 'Tamaño Max. buffer de images (Cuadros)',
    'ONVIF_URL'            => 'URL ONVIF',
    'ONVIF_Options'        => 'Opciones para ONVIF',
    'OutputCodec'          => 'Formato Salida',
    'Encoder'              => 'Codificador',
    'Encode'               => 'Codificado',
    'Camera Passthrough'   => 'Directo Camara',
    'Audio recording only available with FFMPEG' => 'Grabacion audio solo disponible con FFMPEG',
    'Estimated Ram Use'    => 'Estimación uso RAM',
    'Unlimited'            => 'Ilimitada', // Monitor / Buffers -> js
    'Percent'              => 'Porcentaje',
    'Skin'                 => 'Tema',
/******************* 1.37.x **********************************/
    'Capturing'            => 'Capturando',
    'Analysing'            => 'Analizando',
    'Recording'            => 'Grabación',
    'Manufacturer'         => 'Fabricante',
    'Model'                => 'Modelo',
    'Analysis'             => 'Análisis',
    'Motion Detection'     => 'Detección Movimiento',
    'Analysis Image'       => 'Analisis de Imagen',
    'Decoding'             => 'Decodificación',
    'OutputContainer'      => 'Formato Archivo Video',
    'Event Start Command'  => 'Comando Inicio Evento',
    'Event End Command'    => 'Comando Fin Evento',
    'Viewing'              => 'Visualizar',
    'Janus Live Stream'    => 'Usar Janus para "en vivo"',
    'Janus Live Stream Audio' => 'Usar Audio en Janus para "en vivo"',
    'ONVIF_Event_Listener' => 'Receptor Eventos ONVIF',
    'Disabled'             => 'Deshabilitado',
    'Skip Locked'          => 'Saltar Bloqueados',
    'Execute Interval'     => 'Intervalo Ejecución',
    'Toggle cycle sidebar' => 'Barra lateral ciclo',
    'Memory'               => 'Memoria',
    'UnArchived'           => 'Sin Archivar',
    'Fullscreen'           => 'Pantalla Completa',
    'Always'               => 'Siempre',
    'On Demand'            => 'Bajo Demanda',
    'Fit'                  => 'Ajustar',
    'Live'                 => 'En vivo',
    'Scale'                => 'Ajustar',
    'minute'               => 'minuto',
    'minutes'              => 'minutos',
    'on demand'            => 'bajo demanda',
    'On Motion'            => 'Detección movimiento',
    'Prealarm'             => 'Prealarma',
    'Settings only available for Local monitors.' => 'Config solo disponible para monitores locales',
    'KeyFrames Only'       => 'Solo Cuadros Clave',
    'Keyframes + Ondemand'       => 'Cuadros Clave + Bajo Demanda',
    'On Motion / Trigger / etc'  => 'En Movimiento / Trigger / etc',
    'Less important'       => 'Menos importante',
    'Not important'        => 'Sin importancia',
    'Small'                => 'Pequeña',
    'Large'                => 'Grande',
    'Extra Large'          => 'Extra Grande',
    'Camera Passthrough - only for FFMPEG' => 'Directo Camara - unicamente en FFMPEG',
    'Frames only'          => 'Cuadros unicamente',
    'Analysis images only (if available)' => 'Imagenes de Analisis unicamente (Si disponible)',
    'Frames + Analysis images (if available)' => 'Cuadros + Imagenes de Analisis (Si disponible)',
    'Full Colour'          => 'Colores',
    'Y-Channel (Greyscale)' => 'Canal-Y (Escala Grises)',
    'Linear'               => 'Lineal',
    'Discard'              => 'Descartar',
    'Blend'                => 'Mezclar',
    'Blend (25%)'          => 'Mezclar (25%)',
    'Four field motion adaptive - Soft' => 'Four field motion adaptive - Liviano',
    'Four field motion adaptive - Medium' => 'Four field motion adaptive - Medio',
    'Four field motion adaptive - Hard' => 'Four field motion adaptive - Fuerte',
    'No blending'          => 'No mezclar',
    '6.25% (Indoor)'       => '6.25% (Interior)',
    '12.5% (Outdoor)'      => '12.5% (Exterior)',
    'No blending (Alarm lasts forever)' => 'No mezclar (Alarma infinita)',
    '50% (Alarm lasts a moment)' => '50% (Alarma dura un momento)',
    'Change State'         => 'Cambiar estado',
    'Run State'            => 'Estado Ejecución',
//    '3 Wide'               => '3 Ancho', js
    'Showing Analysis'     => 'Mostrar Analisis',
    'ConfirmDeleteTitle'   => 'Borrar Seleccionados',
    'Continuous'           => 'Continuo',
    'ONVIF_Alarm_Text'      => 'Texto Alarma ONVIF', //added 18/07/2022

);

// Complex replacements with formatting and/or placements, must be passed through sprintf
$CLANG = array(
    'CurrentLogin'         => 'Usuario actual es \'%1$s\'',
    'EventCount'           => '%1$s %2$s',
    'LastEvents'           => 'Ultimo %1$s %2$s',
    'LatestRelease'        => 'La última versión es v%1$s, usted tiene la v%2$s.',
    'MonitorCount'         => '%1$s %2$s',
    'MonitorFunction'      => 'Funcion del Monitor %1$s',
    'RunningRecentVer'     => 'Usted tiene la última version de Zoneminder, v%s.',
    'VersionMismatch'      => 'Problemas de versiones, version del sistema es %1$s, version Base de Datos es %2$s.', // Added - 2011-05-25
);

// Variable arrays expressing plurality, see the zmVlang description above
$VLANG = array(
    'Event'                => array( 0=>'Eventos', 1=>'Evento', 2=>'Eventos' ),
    'Monitor'              => array( 0=>'Monitores', 1=>'Monitor', 2=>'Monitores' ),
);

function zmVlang( $langVarArray, $count )
{
    krsort( $langVarArray );
    foreach ( $langVarArray as $key=>$value )
    {
        if ( abs($count) >= $key )
        {
            return( $value );
        }
    }
    die( 'Error, no se puede correlacionar la variable de cadena de idioma' );
}

$OLANG = array(
	'OPTIONS_FFMPEG' => array(
		'Help' => "Los parámetros en este campo se pasan a FFmpeg. Múltiples parámetros pueden ser separados por ,~~ ".
		          "Ejemplos (no ingrese comillas)~~~~".
		          "\"allowed_media_types=video\" Establecer tipo de datos para solicitar desde la cámara (audio, video, data)~~~~".
		          "\"reorder_queue_size=nnn\" Establezca el número de paquetes en el búfer para el manejo de paquetes reordenados~~~~".
		          "\"loglevel=debug\" Establecer nivel info. de FFmpeg (quiet, panic, fatal, error, warning, info, verbose, debug)"
	),
	'OPTIONS_LIBVLC' => array(
		'Help' => "Los parámetros en este campo se pasan a libVLC. Múltiples parámetros pueden ser separados por ,~~ ".
		          "Ejemplos (no ingrese comillas)~~~~".
		          "\"--rtp-client-port=nnn\" Establecer puerto local para usar para datos rtp~~~~". 
		          "\"--verbose=2\" Establecer nivel info. de libVLC"
	),
	
//   ****************Prompts *************************

	'ADD_JPEG_COMMENTS' => array ( 'Prompt'=>'Agregar anotaciones de marca de tiempo jpeg como comentarios de encabezado de archivo'),
	'AUDIT_CHECK_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia verificar la consistencia de la base de datos y del sistema de archivos'),
	'AUDIT_MIN_AGE' => array ( 'Prompt'=>'La antigüedad mínima en segundos de los datos del evento debe ser para poder ser eliminados.'),
	'AUTH_HASH_IPS' => array ( 'Prompt'=>'Incluir direcciones IP en el hash de autenticación'),
	'AUTH_HASH_LOGINS' => array ( 'Prompt'=>'Permitir inicio de sesión mediante hash de autenticación'),
	'AUTH_HASH_SECRET' => array ( 'Prompt'=>'Secreto para codificar información de autenticación hash'),
	'AUTH_HASH_TTL' => array ( 'Prompt'=>'El número de horas durante las que un hash de autenticación es válido.'),
	'AUTH_RELAY' => array ( 'Prompt'=>'Método utilizado para transmitir información de autenticación'),
	'AUTH_TYPE' => array ( 'Prompt'=>'Qué se utiliza para autenticar a los usuarios de ZoneMinder'),
	'BANDWIDTH_DEFAULT' => array ( 'Prompt'=>'Configuración predeterminada para el perfil de ancho de banda utilizado por la interfaz web'),
	'BULK_FRAME_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia se debe escribir masivamente cuadros en la base de datos'),
	'CAPTURES_PER_FRAME' => array ( 'Prompt'=>'Cuántas imágenes se capturan por cuadro rechazado para cámaras locales compartidas'),
	'CHECK_FOR_UPDATES' => array ( 'Prompt'=>'Verifique con zoneminder.com por versiones actualizadas'),
	'COLOUR_JPEG_FILES' => array ( 'Prompt'=>'Colorear archivos JPEG originalmente en escala de grises'),
	'COOKIE_LIFETIME' => array ( 'Prompt'=>'La vida máxima de una COOKIE utilizada al Configurar el controlador de sesión de PHP.'),
	'CPU_EXTENSIONS' => array ( 'Prompt'=>'Utilizar extensiones de CPU avanzadas para aumentar el rendimiento'),
	'CSP_REPORT_URI' => array ( 'Prompt'=>'URI para informar infracciones de seguridad inline de javascript'),
	'CSS_DEFAULT' => array ( 'Prompt'=>'Conjunto predeterminado de archivos css utilizados por la interfaz web'),
	'DATETIME_FORMAT_PATTERN' => array ( 'Prompt'=>'Sobreescribir del formato de Fecha/Hora del sistema.'),
	'DATE_FORMAT_PATTERN' => array ( 'Prompt'=>'Sobreescribir del formato de Fecha del sistema.'),
	'DEFAULT_ASPECT_RATIO' => array ( 'Prompt'=>'La relación de aspecto ancho:alto predeterminada utilizada en los monitores'),
	'DUMP_CORES' => array ( 'Prompt'=>'Cree archivos “core” en caso de falla inesperada del proceso.'),
	'DYN_CURR_VERSION' => array ( 'Prompt'=>''.
	      'Cuál es la versión instalada efectiva de ZoneMinder podría ser'.
	      ' diferente de la actual si se han ignorado versiones.'
        	),
	'DYN_DB_VERSION' => array ( 'Prompt'=>'Cuál es la versión de la base de datos desde zmupdate'),
	'DYN_DONATE_REMINDER_TIME' => array ( 'Prompt'=>'Cuándo será el momento más pronto para recordar acerca de las donaciones'),
	'DYN_LAST_CHECK' => array ( 'Prompt'=>'Cuándo se realizó la última comprobación de la versión en zoneminder.com'),
	'DYN_LAST_VERSION' => array ( 'Prompt'=>'Cuál es la última versión de ZoneMinder registrada en zoneminder.com'),
	'DYN_NEXT_REMINDER' => array ( 'Prompt'=>'Cuándo será el momento más pronto para recordar las versiones'),
	'DYN_SHOW_DONATE_REMINDER' => array ( 'Prompt'=>'Recordar sobre donaciones o no'),
	'EMAIL_HOST' => array ( 'Prompt'=>'La dirección de host de su servidor de correo SMTP'),
	'ENABLE_CSRF_MAGIC' => array ( 'Prompt'=>'Habilitar la biblioteca csrf-magic'),
	'EVENT_CLOSE_MODE' => array ( 'Prompt'=>'Cuando los eventos continuos serán cerrados.'),
	'EVENT_IMAGE_DIGITS' => array ( 'Prompt'=>'Cuántos dígitos significativos se utilizan en la numeración de imágenes de eventos'),
	'FAST_IMAGE_BLENDS' => array ( 'Prompt'=>'Utilizar un algoritmo rápido para mezclar la imagen de referencia'),
	'FEATURES_SNAPSHOTS' => array ( 'Prompt'=>'Habilite la funcionalidad de instantáneas (snapshot).'),
	'FFMPEG_FORMATS' => array ( 'Prompt'=>'Formatos para permitir la generación de video ffmpeg'),
	'FFMPEG_INPUT_OPTIONS' => array ( 'Prompt'=>'Opciones de entrada adicionales para ffmpeg'),
	'FFMPEG_OPEN_TIMEOUT' => array ( 'Prompt'=>'Tiempo de espera en segundos al abrir un stream.'),
	'FFMPEG_OUTPUT_OPTIONS' => array ( 'Prompt'=>'Opciones de salida adicionales para ffmpeg'),
	'FILTER_EXECUTE_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) ejecutar filtros guardados automáticamente'),
	'FILTER_RELOAD_DELAY' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se recargan los filtros en zmfilter'),
	'FONT_FILE_LOCATION' => array ( 'Prompt'=>'Ubicación del archivo de fuente'),
	'FORCED_ALARM_SCORE' => array ( 'Prompt'=>'Puntuación dada a alarmas forzadas'),
	'FROM_EMAIL' => array ( 'Prompt'=>'Dirección de correo electrónico desde la que desea que se originen sus notificaciones de eventos'),
	'HOME_ABOUT' => array ( 'Prompt'=>'Habilitar el menú - Acerca de… - de ZoneMinder.'),
	'HOME_CONTENT' => array ( 'Prompt'=>'Contenido del botón de inicio.'),
	'HOME_URL' => array ( 'Prompt'=>'URL utilizada en el área de inicio/logotipo de la barra de navegación.'),
	'HTTP_TIMEOUT' => array ( 'Prompt'=>'Cuánto tiempo espera ZoneMinder antes de renunciar a las imágenes (milisegundos)'),
	'HTTP_UA' => array ( 'Prompt'=>'El agente de usuario que utiliza ZoneMinder para identificarse'),
	'HTTP_VERSION' => array ( 'Prompt'=>'Versión de HTTP que utilizará ZoneMinder para conectarse'),
	'JANUS_PATH' => array ( 'Prompt'=>'URL servidor Janus ( HTTP/HTTPS:puerto).'),
	'JANUS_SECRET' => array ( 'Prompt'=>'Contraseña para la administración de transmisión de Janus (streaming).'),
	'JPEG_ALARM_FILE_QUALITY' => array ( 'Prompt'=>'Establecer la Configuración de calidad JPEG para los archivos de eventos guardados durante una alarma (1-100)'),
	'JPEG_FILE_QUALITY' => array ( 'Prompt'=>'Establezca la Configuración de calidad JPEG para los archivos de eventos guardados (1-100)'),
	'JPEG_STREAM_QUALITY' => array ( 'Prompt'=>'Establezca la Configuración de calidad JPEG para las imágenes "en vivo" transmitidas (1-100)'),
	'LANG_DEFAULT' => array ( 'Prompt'=>'Idioma predeterminado utilizado por la interfaz web'),
	'LD_PRELOAD' => array ( 'Prompt'=>'Path de la biblioteca para precargar antes de lanzar los demonios (daemons)'),
	'LOCALE_DEFAULT' => array ( 'Prompt'=>'Configuración regional predeterminada utilizada al formatear cadenas de fecha/hora.'),
	'LOG_ALARM_ERR_COUNT' => array ( 'Prompt'=>'Número de errores que indican el estado de alarma del sistema'),
	'LOG_ALARM_FAT_COUNT' => array ( 'Prompt'=>'Número de errores fatales que indican el estado de alarma del sistema'),
	'LOG_ALARM_WAR_COUNT' => array ( 'Prompt'=>'Número de avisos (warnings) que indican el estado de alarma del sistema'),
	'LOG_ALERT_ERR_COUNT' => array ( 'Prompt'=>'Número de errores que indican el estado de alerta del sistema'),
	'LOG_ALERT_FAT_COUNT' => array ( 'Prompt'=>'Número de errores fatales que indican el estado de alerta del sistema'),
	'LOG_ALERT_WAR_COUNT' => array ( 'Prompt'=>'Número de advertencias (warnings) que indican el estado de alerta del sistema'),
	'LOG_CHECK_PERIOD' => array ( 'Prompt'=>'Período de tiempo utilizado al calcular el estado general del sistema'),
	'LOG_DATABASE_LIMIT' => array ( 'Prompt'=>'Número máximo de entradas de registro (logs) a retener'),
	'LOG_DEBUG' => array ( 'Prompt'=>'Activar depuración'),
	'LOG_DEBUG_FILE' => array ( 'Prompt'=>'Donde se envía la información de depuración adicional'),
	'LOG_DEBUG_LEVEL' => array ( 'Prompt'=>'Qué nivel de depuración adicional quiere habilitarse'),
	'LOG_DEBUG_TARGET' => array ( 'Prompt'=>'Qué componentes deberían tener habilitada la depuración adicional'),
	'LOG_FFMPEG' => array ( 'Prompt'=>'Registrar mensajes FFMPEG'),
	'LOG_LEVEL_DATABASE' => array ( 'Prompt'=>'Guardar la salida de registro (logs) en la base de datos'),
	'LOG_LEVEL_FILE' => array ( 'Prompt'=>'Guarde la salida de registro (logs) a los archivos del componente'),
	'LOG_LEVEL_SYSLOG' => array ( 'Prompt'=>'Guardar la salida de registro (logs) en el registro del sistema (syslog)'),
	'LOG_LEVEL_WEBLOG' => array ( 'Prompt'=>'Guardar la salida de registro (logs) en el weblog'),
	'MAX_RESTART_DELAY' => array ( 'Prompt'=>'Retraso máximo (en segundos) entre los intentos de reinicio del daemon.'),
	'MAX_RTP_PORT' => array ( 'Prompt'=>'Puerto máximo en el que ZoneMinder escuchará el tráfico RTP'),
	'MAX_SUSPEND_TIME' => array ( 'Prompt'=>'Tiempo máximo que un monitor puede tener suspendida la detección de movimiento'),
	'MESSAGE_ADDRESS' => array ( 'Prompt'=>'Dirección de correo electrónico a la que enviar los detalles del evento coincidente'),
	'MESSAGE_BODY' => array ( 'Prompt'=>'Cuerpo del mensaje utilizado para enviar detalles de eventos coincidentes'),
	'MESSAGE_SUBJECT' => array ( 'Prompt'=>'Asunto del mensaje utilizado para enviar detalles de eventos coincidentes'),
	'MIN_RTP_PORT' => array ( 'Prompt'=>'Puerto mínimo en el que ZoneMinder escuchará el tráfico RTP'),
	'MIN_RTSP_PORT' => array ( 'Prompt'=>'Inicio del rango de puertos para contactar para transmisión de video (streaming) RTSP.'),
	'MIN_STREAMING_PORT' => array ( 'Prompt'=>'Rango de puertos alternativo para contactar para streaming.'),
	'MPEG_LIVE_FORMAT' => array ( 'Prompt'=>'Formato para reproducir las transmisiones de video "en vivo"'),
	'MPEG_REPLAY_FORMAT' => array ( 'Prompt'=>'Formato para reproducir las secuencias de video de pregrabadas'),
	'MPEG_TIMED_FRAMES' => array ( 'Prompt'=>'Etiquetar cuadros de video con una marca de tiempo para una transmisión más realista'),
	'NEW_MAIL_MODULES' => array ( 'Prompt'=>'Utilizar un método perl más nuevo para envío de correos electrónicos'),
	'OPT_ADAPTIVE_SKIP' => array ( 'Prompt'=>'Debería el análisis de cuadros tratar de ser eficiente en saltar cuadros'),
	'OPT_CONTROL' => array ( 'Prompt'=>'Soportar cámaras controlables (por ejemplo PTZ)'),
	'OPT_EMAIL' => array ( 'Prompt'=>'Debe ZoneMinder envíar por correo electrónico los detalles de los eventos que coinciden con los filtros correspondientes'),
	'OPT_FAST_DELETE' => array ( 'Prompt'=>'Eliminar solo registros de la base de datos de eventos para aumentar la velocidad'),
	'OPT_FFMPEG' => array ( 'Prompt'=>'Está instalado el codificador/descodificador de video ffmpeg'),
	'OPT_GEOLOCATION_ACCESS_TOKEN' => array ( 'Prompt'=>'Token de acceso para el proveedor de tiles de los mapas.'),
	'OPT_GEOLOCATION_TILE_PROVIDER' => array ( 'Prompt'=>'Proveedor de tiles para los mapas.'),
	'OPT_GOOG_RECAPTCHA_SECRETKEY' => array ( 'Prompt'=>'Su clave secreta de recaptcha'),
	'OPT_GOOG_RECAPTCHA_SITEKEY' => array ( 'Prompt'=>'Tu clave de sitio recaptcha'),
	'OPT_MESSAGE' => array ( 'Prompt'=>'Debería ZoneMinder enviarle un mensaje con detalles de eventos que coincidan con los filtros correspondientes'),
	'OPT_TRIGGERS' => array ( 'Prompt'=>'Conectar triggers de eventos externos a través de sockets o archivos “/dev/“'),
	'OPT_UPLOAD' => array ( 'Prompt'=>'Debe ZoneMinder permitir la carga de eventos desde filtros'),
	'OPT_USE_API' => array ( 'Prompt'=>'Habilitar API de ZoneMinder'),
	'OPT_USE_AUTH' => array ( 'Prompt'=>'Autenticar los inicios de sesión de los usuarios en ZoneMinder'),
	'OPT_USE_EVENTNOTIFICATION' => array ( 'Prompt'=>'Habilitar servidor de notificación de eventos de terceros'),
	'OPT_USE_GEOLOCATION' => array ( 'Prompt'=>'Agregue funciones de geolocalización a ZoneMinder.'),
	'OPT_USE_GOOG_RECAPTCHA' => array ( 'Prompt'=>'Agregue reCaptcha de Google a la página de inicio de sesión'),
	'OPT_USE_LEGACY_API_AUTH' => array ( 'Prompt'=>'Habilitar la autenticación legada del API'),
	'OPT_X10' => array ( 'Prompt'=>'Soporte interfazar con dispositivos X10'),
	'PATH_FFMPEG' => array ( 'Prompt'=>'Path al codificador ffmpeg mpeg (opcional)'),
	'RAND_STREAM' => array ( 'Prompt'=>'Agregar una cadena aleatoria para evitar el  caching de streams'),
	'RECORD_DIAG_IMAGES' => array ( 'Prompt'=>'Grabar imágenes de diagnóstico de alarmas intermedias puede ser muy lento'),
	'RECORD_DIAG_IMAGES_FIFO' => array ( 'Prompt'=>'Grabación de diagnóstico de alarma intermedia use fifo en lugar de archivos (más rápido)'),
	'RECORD_EVENT_STATS' => array ( 'Prompt'=>'Registrar información estadística de eventos apague si se torna demasiado lento'),
	'RUN_AUDIT' => array ( 'Prompt'=>'Ejecute zmaudit para verificar la consistencia de los datos'),
	'SHM_KEY' => array ( 'Prompt'=>'Llave root de memoria compartida a usar'),
	'SHOW_PRIVACY' => array ( 'Prompt'=>'Presentar la declaración de privacidad'),
	'SKIN_DEFAULT' => array ( 'Prompt'=>'Tema predeterminado utilizado por la interfaz web'),
	'SSMTP_MAIL' => array ( 
		'Prompt' => ' '.
      		'Utilice un servidor de correo SSMTP si está disponible.'.
      		' NEW_MAIL_MODULES debe estar habilitado'
      		),
	'SSMTP_PATH' => array ( 'Prompt'=>'Path del ejecutable SSMTP'),
	'STATS_UPDATE_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia actualizar las estadísticas de la base de datos'),
	'STRICT_VIDEO_CONFIG' => array ( 'Prompt'=>'Permitir que los errores en la configuración de video sean fatales'),
	'SYSTEM_SHUTDOWN' => array ( 'Prompt'=>'Permitir que los usuarios administradores apaguen o reinicien el sistema desde la interfaz de usuario de ZoneMinder.'),
	'TELEMETRY_DATA' => array ( 'Prompt'=>'Enviar información de uso a ZoneMinder'),
	'TELEMETRY_INTERVAL' => array ( 'Prompt'=>'Intervalo en segundos entre actualizaciones de telemetría.'),
	'TELEMETRY_LAST_UPLOAD' => array ( 'Prompt'=>'Cuándo ocurrió la última carga de telemetría a ZoneMinder'),
	'TELEMETRY_SERVER_ENDPOINT' => array ( 'Prompt'=>'URL a la que ZoneMinder enviará datos de uso'),
	'TELEMETRY_UUID' => array ( 'Prompt'=>'Identificador único para la telemetría de ZoneMinder'),
	'TIMESTAMP_CODE_CHAR' => array ( 'Prompt'=>'Carácter a utilizar para identificar códigos de marca de tiempo'),
	'TIMESTAMP_ON_CAPTURE' => array ( 'Prompt'=>'Agregar marca de tiempo a Imágenes tan pronto como se capturan'),
	'TIMEZONE' => array ( 'Prompt'=>'Zona horaria que debe usar php.'),
	'TIME_FORMAT_PATTERN' => array ( 'Prompt'=>'Sobreescribir del formato de Hora del sistema.'),
	'UPDATE_CHECK_PROXY' => array ( 'Prompt'=>'URL del proxy si es necesario para acceder a zoneminder.com'),
	'UPLOAD_ARCH_ANALYSE' => array ( 'Prompt'=>'Incluir los archivos de análisis en el evento archivado'),
	'UPLOAD_ARCH_COMPRESS' => array ( 'Prompt'=>'Se deben comprimir los eventos archivados'),
	'UPLOAD_ARCH_FORMAT' => array ( 'Prompt'=>'En qué formato deben crearse los eventos a ser cargados remotamente.'),
	'UPLOAD_DEBUG' => array ( 'Prompt'=>'Activar la depuración de carga remota'),
	'UPLOAD_FTP_PASSIVE' => array ( 'Prompt'=>'Use ftp pasivo al cargar remotamente'),
	'UPLOAD_HOST' => array ( 'Prompt'=>'Servidor remoto para cargar eventos'),
	'UPLOAD_LOC_DIR' => array ( 'Prompt'=>'El directorio local en el que crear archivos para cargar remotamente'),
	'UPLOAD_PASS' => array ( 'Prompt'=>'Contraseña del servidor remoto'),
	'UPLOAD_PORT' => array ( 'Prompt'=>'Puerto en el servidor de carga remota si no es el predeterminado (solo SFTP)'),
	'UPLOAD_PROTOCOL' => array ( 'Prompt'=>'Qué protocolo utilizar para subir eventos al servidor remoto'),
	'UPLOAD_REM_DIR' => array ( 'Prompt'=>'Directorio remoto al cual cargar'),
	'UPLOAD_STRICT' => array ( 'Prompt'=>'Requerir una verificación estricta de la clave de host para las cargas de SFTP'),
	'UPLOAD_TIMEOUT' => array ( 'Prompt'=>'Cuánto tiempo permitir que la transferencia para cada archivo tome '),
	'UPLOAD_USER' => array ( 'Prompt'=>'Nombre de usuario del servidor remoto'),
	'URL' => array ( 'Prompt'=>'URL de su instalación de ZoneMinder'),
	'USER_SELF_EDIT' => array ( 'Prompt'=>'Permitir que los usuarios sin privilegios cambien sus datos'),
	'USE_DEEP_STORAGE' => array ( 'Prompt'=>'Utilizar una jerarquía de sistema de archivos profunda para eventos'),
	'V4L_MULTI_BUFFER' => array ( 'Prompt'=>'Utilice más de un búfer para dispositivos Video 4 Linux'),
	'WATCH_CHECK_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia verificar que los demonios (daemons) de captura no se hayan bloqueado'),
	'WATCH_MAX_DELAY' => array ( 'Prompt'=>'El retraso máximo permitido desde la última imagen capturada'),
	'WEB_ALARM_SOUND' => array ( 'Prompt'=>'Sonido a reproducir en alarma debe ponerse en el directorio de sonidos'),
	'WEB_ANIMATE_THUMBS' => array ( 'Prompt'=>'Amplíe y muestre la transmisión en vivo cuando se pasa el mouse sobre la miniatura del monitor'),
	'WEB_COMPACT_MONTAGE' => array ( 'Prompt'=>'Compacte la vista del montaje ocultando los detalles adicionales'),
	'WEB_CONSOLE_BANNER' => array ( 'Prompt'=>'Mensaje de texto arbitrario cerca de la parte superior de la consola'),
	'WEB_EVENTS_PER_PAGE' => array ( 'Prompt'=>'Cuántos eventos enumerar por página en modo paginado'),
	'WEB_EVENT_DISK_SPACE' => array ( 'Prompt'=>'Mostrar el espacio en disco utilizado por cada evento.'),
	'WEB_EVENT_SORT_FIELD' => array ( 'Prompt'=>'Campo predeterminado por el que se ordenan las listas de eventos'),
	'WEB_EVENT_SORT_ORDER' => array ( 'Prompt'=>'Orden predeterminado por el que se ordenan las listas de eventos'),
	'WEB_FILTER_SOURCE' => array ( 'Prompt'=>'Cómo filtrar información en la columna origen.'),
	'WEB_H_AJAX_TIMEOUT' => array ( 'Prompt'=>'Cuánto tiempo esperar las respuestas de solicitud de Ajax (ms)'),
	'WEB_H_CAN_STREAM' => array ( 'Prompt'=>'Ignorar la detección automática de la capacidad de transmisión (streaming) del navegador'),
	'WEB_H_DEFAULT_RATE' => array ( 'Prompt'=>'Cuál es el factor de frecuencia de reproducción predeterminado que se aplica a las visualizaciones de eventos (%)'),
	'WEB_H_DEFAULT_SCALE' => array ( 'Prompt'=>'Cuál es el factor de escala predeterminado que se aplica a las vistas "en vivo" o "evento" (%)'),
	'WEB_H_EVENTS_VIEW' => array ( 'Prompt'=>'Cuál debería ser la vista predeterminada para varios eventos.'),
	'WEB_H_REFRESH_CYCLE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana de visualización del ciclo cambia al siguiente monitor'),
	'WEB_H_REFRESH_EVENTS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la lista de eventos en la ventana de observación'),
	'WEB_H_REFRESH_IMAGE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la imagen visualizada (si no es streaming)'),
	'WEB_H_REFRESH_MAIN' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana principal de la consola debe actualizarse'),
	'WEB_H_REFRESH_NAVBAR' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) debe actualizarse el encabezado de navegación'),
	'WEB_H_REFRESH_STATUS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza el estado en la ventana de observación'),
	'WEB_H_SCALE_THUMBS' => array ( 'Prompt'=>'Escale miniaturas en eventos ancho de banda versus CPU en reescalado'),
	'WEB_H_SHOW_PROGRESS' => array ( 'Prompt'=>'Muestra el progreso de la reproducción en el visor de eventos.'),
	'WEB_H_STREAM_METHOD' => array ( 'Prompt'=>'Qué método debe usarse para enviar secuencias de video (streams) a su navegador.'),
	'WEB_H_VIDEO_BITRATE' => array ( 'Prompt'=>'Cuál debe ser la tasa de bits de la transmisión (stream) codificada de video'),
	'WEB_H_VIDEO_MAXFPS' => array ( 'Prompt'=>'Cuál debe ser la velocidad de cuadro máxima para la transmisión de video'),
	'WEB_ID_ON_CONSOLE' => array ( 'Prompt'=>'Debe la consola mostrar la identificación del monitor (Id)'),
	'WEB_LIST_THUMBS' => array ( 'Prompt'=>'Mostrar mini-miniaturas de imágenes de eventos en la lista de eventos'),
	'WEB_LIST_THUMB_HEIGHT' => array ( 'Prompt'=>'Alto de las miniaturas que aparecen en la lista de eventos'),
	'WEB_LIST_THUMB_WIDTH' => array ( 'Prompt'=>'Ancho de las miniaturas que aparecen en la lista de eventos'),
	'WEB_L_AJAX_TIMEOUT' => array ( 'Prompt'=>'Cuánto tiempo esperar las respuestas de solicitud de Ajax (ms)'),
	'WEB_L_CAN_STREAM' => array ( 'Prompt'=>'Ignorar la detección automática de la capacidad de transmisión (streaming) del navegador'),
	'WEB_L_DEFAULT_RATE' => array ( 'Prompt'=>'Cuál es el factor de frecuencia de reproducción predeterminado que se aplica a las visualizaciones de eventos (%)'),
	'WEB_L_DEFAULT_SCALE' => array ( 'Prompt'=>'Cuál es el factor de escala predeterminado que se aplica a las vistas "en vivo" o "evento" (%)'),
	'WEB_L_EVENTS_VIEW' => array ( 'Prompt'=>'Cuál debería ser la vista predeterminada para varios eventos.'),
	'WEB_L_REFRESH_CYCLE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana de visualización del ciclo cambia al siguiente monitor'),
	'WEB_L_REFRESH_EVENTS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la lista de eventos en la ventana de observación'),
	'WEB_L_REFRESH_IMAGE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la imagen visualizada (si no es streaming)'),
	'WEB_L_REFRESH_MAIN' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana principal de la consola debe actualizarse'),
	'WEB_L_REFRESH_NAVBAR' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) debe actualizarse el encabezado de navegación'),
	'WEB_L_REFRESH_STATUS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza el estado en la ventana de observación'),
	'WEB_L_SCALE_THUMBS' => array ( 'Prompt'=>'Escale miniaturas en eventos ancho de banda versus CPU en reescalado'),
	'WEB_L_SHOW_PROGRESS' => array ( 'Prompt'=>'Muestra el progreso de la reproducción en el visor de eventos.'),
	'WEB_L_STREAM_METHOD' => array ( 'Prompt'=>'Qué método debe usarse para enviar secuencias de video (streams) a su navegador.'),
	'WEB_L_VIDEO_BITRATE' => array ( 'Prompt'=>'Cuál debe ser la tasa de bits de la transmisión (stream) codificada de video'),
	'WEB_L_VIDEO_MAXFPS' => array ( 'Prompt'=>'Cuál debe ser la velocidad de cuadro máxima para la transmisión de video'),
	'WEB_M_AJAX_TIMEOUT' => array ( 'Prompt'=>'Cuánto tiempo esperar las respuestas de solicitud de Ajax (ms)'),
	'WEB_M_CAN_STREAM' => array ( 'Prompt'=>'Ignorar la detección automática de la capacidad de transmisión (streaming) del navegador'),
	'WEB_M_DEFAULT_RATE' => array ( 'Prompt'=>'Cuál es el factor de frecuencia de reproducción predeterminado que se aplica a las visualizaciones de eventos (%)'),
	'WEB_M_DEFAULT_SCALE' => array ( 'Prompt'=>'Cuál es el factor de escala predeterminado que se aplica a las vistas "en vivo" o "evento" (%)'),
	'WEB_M_EVENTS_VIEW' => array ( 'Prompt'=>'Cuál debería ser la vista predeterminada para varios eventos.'),
	'WEB_M_REFRESH_CYCLE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana de visualización del ciclo cambia al siguiente monitor'),
	'WEB_M_REFRESH_EVENTS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la lista de eventos en la ventana de observación'),
	'WEB_M_REFRESH_IMAGE' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza la imagen visualizada (si no es streaming)'),
	'WEB_M_REFRESH_MAIN' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) la ventana principal de la consola debe actualizarse'),
	'WEB_M_REFRESH_NAVBAR' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) debe actualizarse el encabezado de navegación'),
	'WEB_M_REFRESH_STATUS' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) se actualiza el estado en la ventana de observación'),
	'WEB_M_SCALE_THUMBS' => array ( 'Prompt'=>'Escale miniaturas en eventos ancho de banda versus CPU en reescalado'),
	'WEB_M_SHOW_PROGRESS' => array ( 'Prompt'=>'Muestra el progreso de la reproducción en el visor de eventos.'),
	'WEB_M_STREAM_METHOD' => array ( 'Prompt'=>'Qué método debe usarse para enviar secuencias de video (streams) a su navegador.'),
	'WEB_M_VIDEO_BITRATE' => array ( 'Prompt'=>'Cuál debe ser la tasa de bits de la transmisión (stream) codificada de video'),
	'WEB_M_VIDEO_MAXFPS' => array ( 'Prompt'=>'Cuál debe ser la velocidad de cuadro máxima para la transmisión de video'),
	'WEB_NAVBAR_TYPE' => array ( 'Prompt'=>'Estilo de la barra de navegación de la consola web'),
	'WEB_POPUP_ON_ALARM' => array ( 'Prompt'=>'Debe la ventana del monitor pasar a primer plano si ocurre una alarma'),
	'WEB_RESIZE_CONSOLE' => array ( 'Prompt'=>'Debe la ventana de la consola cambiar de tamaño para ajustarse al monitor'),
	'WEB_SOUND_ON_ALARM' => array ( 'Prompt'=>'Debería la ventana del monitor reproducir un sonido si ocurre una alarma'),
	'WEB_TITLE' => array ( 'Prompt'=>'Mostrar el título si el sitio hace referencia a sí mismo.'),
	'WEB_TITLE_PREFIX' => array ( 'Prompt'=>'El prefijo del título que se muestra en cada ventana'),
	'WEB_USE_OBJECT_TAGS' => array ( 'Prompt'=>'Empaquetar en los tags de objeto el atributo -incrustado- para contenido multimedia'),
	'WEB_XFRAME_WARN' => array ( 'Prompt'=>'Advertir cuando las X-Frame-Options del sitio web está Config_Trurado con el mismo origen'),
	'WEIGHTED_ALARM_CENTRES' => array ( 'Prompt'=>'Utilice un algoritmo ponderado para calcular el centro de una alarma'),
	'X10_DB_RELOAD_INTERVAL' => array ( 'Prompt'=>'Con qué frecuencia (en segundos) el demonio (daemon) X10 recarga los monitores desde la base de datos'),
	'X10_DEVICE' => array ( 'Prompt'=>'A qué dispositivo está conectado su controlador X10'),
	'X10_HOUSE_CODE' => array ( 'Prompt'=>'Qué código de casa X10 se debe usar'),

//   ***************End Prompts **********************


);

?>
