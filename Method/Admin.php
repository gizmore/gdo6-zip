<?php
namespace GDO\ZIP\Method;

use GDO\Core\MethodAdmin;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\Util\Process;
use GDO\ZIP\Module_ZIP;

final class Admin extends MethodForm
{
    use MethodAdmin;
    
    public function createForm(GDT_Form $form)
    {
        $form->addFields([
            GDT_Submit::make()->label('detect_zip'),
            GDT_AntiCSRF::make(),
        ]);
    }
    
    public function formValidated(GDT_Form $form)
    {
        if ($path = Process::commandPath("zip"))
        {
            Module_ZIP::instance()->saveConfigVar('zip_binary', $path);
        }
        else
        {
            return $this->error('err_file_not_found', ['zip']);
        }
        
        if ($path = Process::commandPath("gzip"))
        {
            Module_ZIP::instance()->saveConfigVar('gzip_binary', $path);
        }
        else
        {
            return $this->error('err_file_not_found', ['gzip']);
        }
    }

}