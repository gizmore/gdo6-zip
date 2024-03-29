<?php
namespace GDO\ZIP;

use GDO\Core\GDO_Module;
use GDO\File\GDT_Path;
use GDO\ZIP\Method\Admin;

/**
 * Holds path for zip and gzip.
 * Detector in admin function.
 * If detector is not working for your windows box try `where zip` in a cmdline and use that value.
 * 
 * @author gizmore
 * @version 6.10
 * @since 6.10
 */
final class Module_ZIP extends GDO_Module
{
    ##############
    ### Module ###
    ##############
    public function href_administrate_module() { return $this->href('Admin'); }
    public function onLoadLanguage() { return $this->loadLanguage('lang/zip'); }

    ###############
    ### Install ###
    ###############
    public function onInstall()
    {
    	Admin::make()->detectBinaries();
    }
    
    ##############
    ### Config ###
    ##############
    public function getConfig()
    {
        return [
            GDT_Path::make('gzip_binary')->initial('gzip')->existingFile(),
            GDT_Path::make('zip_binary')->initial('zip')->existingFile(),
        ];
    }
    public function cfgGZipPath() { return $this->getConfigVar('gzip_binary'); }
    public function cfgZipPath() { return $this->getConfigVar('zip_binary'); }
    
}
