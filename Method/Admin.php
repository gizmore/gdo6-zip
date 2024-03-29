<?php
namespace GDO\ZIP\Method;

use GDO\Core\MethodAdmin;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\Util\Process;
use GDO\ZIP\Module_ZIP;

/**
 * Admin functions for the ZIP module.
 * @author gizmore
 */
final class Admin extends MethodForm
{
    use MethodAdmin;
    
    public function createForm(GDT_Form $form)
    {
        $form->addFields([
            GDT_AntiCSRF::make(),
        ]);
        $form->actions()->addField(GDT_Submit::make()->label('detect_zip'));
    }
    
    public function formValidated(GDT_Form $form)
    {
    	$this->detectBinaries();
    }
    
    public function detectBinaries()
    {
        if ($path = Process::commandPath("zip"))
        {
            Module_ZIP::instance()->saveConfigVar('zip_binary', $path);
            $this->message('msg_zip_detected');
        }
        else
        {
            return $this->error('err_file_not_found', ['zip']);
        }
        
        if ($path = Process::commandPath("gzip"))
        {
            Module_ZIP::instance()->saveConfigVar('gzip_binary', $path);
            $this->message('msg_gzip_detected');
        }
        else
        {
            return $this->error('err_file_not_found', ['gzip']);
        }
    }

}
