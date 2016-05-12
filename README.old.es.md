# MySEO - SEO OnPage en tu foro MyBB  

Are you searching for **english instructions**? [Click here](https://github.com/BitLiberal/MySEO/blob/master/README.es.md)  

#### Indice:
 1. [Descripcion](#descripcion)
 2. [Como instalar MySEO](#como-instalar-myseo)
    * [Instalar Sistema NoFollow](#instalar-sistema-nofollow)
	* [Instalar extras para el plugin Google SEO](#instalar-extras-para-el-plugin-google-seo)
    * [Optimiza el codigo de las plantillas](#optimiza-el-codigo-de-las-plantillas)
 3. [Como desinstalar MySEO](#como-desinstalar-myseo)
    * [Borrar codigo modificado de las plantillas.](#borrar-codigo-modificado-de-las-plantillas)

## Descripcion
MySEO es un plugin para el sistema de foro MyBB que crea e instala codigos HTML en las plantillas de tus temas para mejorar el seo interno (SEO OnPage) de tu foro.  
Por ejemplo, añadiendo meta keywords, meta descripciones, titles mejorados, etc.

**Convertira cosas como esto:**  
![Mal SEO OnPage en el Indice](http://i.imgur.com/L2agGob.png)
![Mal SEO OnPage en el Indice](http://i.imgur.com/3i6UbnI.png) 

**En esto:**  
![Buen SEO OnPage en el Indice](http://i.imgur.com/M2ajMql.png) 
![Buen SEO OnPage en el Indice](http://i.imgur.com/LJkB0EG.png)

## Como instalar MySEO

Instalarlo es muy facil, solo tienes que descargar la ultima version (desde [Github](https://github.com/BitLiberal/MySEO)) y subir el contenido de la carpeta "Upload" a la carpeta raiz de tu foro (la carpeta principal, donde se encuentra *index.php*).  
**Atencion:**  
Debes tener ciertos codigos en las plantillas para que se instale correctamente. Si tu plantilla es de serie no te preocupes, pero si no es asi:
* Ve a la plantilla *headerinclude* y busca `{$stylesheets}`. Si no lo encuentras, añadelo tu mismo.
* Ve a la plantilla *footer* y busca `{$task_image}`. Si no lo encuentras, añadelo tu mismo.

Listo, ahora solo tienes que instalar el sistema NoFollow y si tienes el plugin Google SEO, sus extras:

#### Quitar cambios en el core
**Esto solo es necesario si actualizas de la versión 1.0**.  
En anteriores versiones de MySEO, para aplicar el sistema NoFollow se necesitaba editar manualmente el archivo *class_parser.php* para que funcionara.  
Ahora ya no es necesario. Para eliminar esos cambios, busca este codigo en */inc/class_parser.php* :
 ````php
/* MOD MySEO
    Original code:
    $name = preg_replace("#&amp;\#([0-9]+);#si", "&#$1;", $name); // Fix & but allow unicode
    $link = "<a href=\"$fullurl\" target=\"_blank\"{$nofollow}>$name</a>";
    return $link;
    */

    global $mybb, $settings;
    $urldelforo = $settings['bburl'];
    $buscar_procedencia = strpos($fullurl, $urldelforo);
    $name = preg_replace("#&amp;\#([0-9]+);#si", "&#$1;", $name);
    if ($buscar_procedencia === false) {
    $link = "<a rel=\"nofollow\" href=\"$fullurl\" target=\"_blank\"{$nofollow}>$name</a>";
    return $link;
    } else {
    $link = "<a href=\"$fullurl\" target=\"_blank\">$name</a>";
    return $link;
            }
    /* MOD MySEO */
````
 
Y reemplazalo por este:
 ````php
    $name = preg_replace("#&amp;\#([0-9]+);#si", "&#$1;", $name); // Fix & but allow unicode
    $link = "<a href=\"$fullurl\" target=\"_blank\"{$nofollow}>$name</a>";
    return $link;
 ````

 Y listo.

#### Instalar extras para el plugin Google SEO
(Si no quieres instalar estas mejoras, **simplemente ignora estas instrucciones**).  
MySEO trae unas configuraciones de serie para mejorar y pulir el uso del plugin [Google SEO](http://mods.mybb.com/view/google-seo).
Las mejoras son:  
 * Añadir el frecuencia de cambio (una sugerencia a Google para que revisite tu foro para ver el nuevo contenido, muy indicado)
 * Añadir la prioridad a las URL's de temas, foros, anuncios, etc, **casi obligado** por [diversos motivos](https://github.com/BitLiberal/MySEO/wiki/En-construccion---Coming-soon#en-construccion)
 * Inutilizado el sistema de NoFollow de Google SEO (para que no afecte al del plugin MySEO). 
 * **Para los foros en español**, una traduccion del 404 de Google SEO.  

Para hacer que estos extras funcionen, se deben sustituir ciertos archivos de Google SEO, para eso debes [descargar la carpeta *Extras Google Seo*](https://github.com/BitLiberal/MySEO/releases/download/v1.0/Extras.Google.SEO.rar), copiar los archivos y pegarlos en la carpeta raiz de tu foro MyBB. **¡Listo!**


#### Optimiza el codigo de las plantillas
Para que no existan confusiones en tus plantillas (por ejemplo, los codigos que ya trae MyBB de serie, si no se eliminan pueden haber duplicaciones), sigue estos pasos:  
* En plantilla *index*:
	* Borrar etiquetas `<title> </title>` y su contenido (ej: `<title>{$mybb->settings['bbname']}</title>`).
* En plantilla *forumdisplay*:
    * Borrar etiquetas `<title> </title>` y su contenido (ej: `<title>{$mybb->settings['bbname']} - {$foruminfo['name']}</title>`).
* En plantilla *showthread*:
	* Borrar etiquetas `<title> </title>` y su contenido (ej: `<title>{$thread['subject']}</title>`).
* En plantilla *member_profile*:
	* Borrar etiquetas `<title> </title>` y su contenido (ej: `<title>{$mybb->settings['bbname']} - {$lang->profile}</title>`).

## Como desinstalar MySEO

#### Borrar codigo modificado de las plantillas
Para su correcta identificacion, TODOS los codigos introducidos por el plugin vienen rodeados de el comentario  
`<!-- Site optimized with MySEO 1.0 --> `, para borrar los codigos (ya sea al desinstalar como explica [aqui](#aviso), o modificar los codigos) solo tienes que acceder a las siguientes plantillas y borrarlos, incluidos los comentarios html:
	* forumdisplay
	* footer
	* index
	* headerinclude
	* member_profile


#### Aviso
Para favorecer la customizacion (y en gran parte porque yo no soy un programador profesional) si modificas los codigos instalados **de serie** por el plugin MySEO, estos no seran borrados, ni los personalizados ni los de serie.
Tranquil@, como explico [aqui](#borrar-codigo-modificado-de-las-plantillas), es muy facil borrarlo.