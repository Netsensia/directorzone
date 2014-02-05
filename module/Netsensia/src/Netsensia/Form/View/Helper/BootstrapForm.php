<?php
namespace Netsensia\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Zend\Form\View\Helper\FormElement;
use Zend\Form\Element\Submit;

class BootstrapForm extends AbstractHelper
{
    protected $form;
    protected $view;
    protected $options;
    
    private $hasImage;
    private $imageUploadId;
 
    /**
     * __invoke
     *
     * @access public
     * @param  Zend\Form\Form $form
     * @param  string $title
     * @return String
     */
    public function __invoke($form, $title, $action, $options = array())
    {
        $this->form     = $form;
        $this->view     = $this->getView();
        $this->options  = $options;
        
        $this->openForm($title, $action);
        
        $this->renderFieldsets();
        
        $this->renderAdditionalElements();
        $this->renderButton();
        $this->closeForm();
        
        $this->renderJavascript();
    }
    
    protected function renderElements($elements)
    {
        echo('<div class="well">');
        
        $this->hasImage = false;
        
        foreach ($elements as $element) {
            if ($element instanceof Submit) {
                continue;
            }
            
            if (strpos($element->getAttribute('class'), 'image-upload') !== false) {
                $this->hasImage = true;
                $this->imageUploadId = $element->getAttribute('id');
                ?>
                <img id="image-upload-thumbnail" data-src="holder.js/260x180" alt="260x180" style="margin-top:1em; width: 260px; height: 180px;" src="">
                <div>
                <a id="remove-image" href="#">Remove Image</a>
                </div>
                <?php

            }
            $isInvisibleOther = (strpos($element->getAttribute('class'), 'invisible-other') !== false);
            
            if ($isInvisibleOther) {
                $id = $element->getAttribute('id');
                echo('<div id="' . $id . '" class="control-group invisible-other">');
            } else {
                echo('<div class="control-group">');
            }
            
            echo('<label class="control-label">' . $element->getLabel() . '</label>');

            echo('<div class="controls">');
            
            if ($element->getAttribute('icon')) {
                echo('<div class="input-group">');
                echo('<span class="input-group-addon"><i class="glyphicon glyphicon-' . $element->getAttribute('icon') . '"></i></span>');
                echo $this->view->formElement($element);
                echo('</div>');
            } else {
                echo $this->view->formElement($element);
            }
            
            if ($element->getMessages()) {
                foreach ($element->getMessages() as $message) {
                    echo('<div class="form-field-error">');
                    echo($message);
                    echo('</div>');
                }
            }
            if ($element->getName() == 'password') {
                echo('<p id="password-strength" class="hint"/></p>');
            }
            echo('</div>');
            echo('</div>');
        }
        echo('</div>');
        
    }
    
    protected function renderFieldsets()
    {
        foreach ($this->form->getFieldsets() as $fieldset) {
            $elements = $fieldset->getElements();
            echo('<fieldset name="' . $fieldset->getName() . '">');
            $this->renderElements($elements);
            echo('</fieldset>');
        }
    }
    
    protected function renderSubmit($elements)
    {
        foreach ($elements as $element) {
            if ($element instanceof Submit) {
                $element->setAttribute('class', 'btn');
                echo $this->view->formElement($element);
            }
        }
    }
    
    protected function renderAdditionalElements()
    {
        $numVisibleElements = 0;
        foreach ($this->form->getElements() as $element) {
            if ($element instanceof Submit) {
                continue;
            }
            $numVisibleElements ++;
        }
        if ($numVisibleElements > 0) {
            $this->renderElements($this->form->getElements());
        }
    }
    
    protected function renderButton()
    {
        if ($this->form->getElements()) {
            $this->renderSubmit($this->form->getElements());
        }
    }
    
    protected function renderMessages()
    {
        if ($this->form->getMessages()) {
            echo('<div class="alert alert-danger">');
            echo('<button type="button" class="close" data-dismiss="alert">&times;</button>');
            echo($this->getView()->translate(
                'There were some errors on the form.  ' .
                'Please review your entries and try again.'
            ));
            echo('</div>');
        }
    }
    
    private function renderJavascript()
    {
        if ($this->hasImage) {
            ?>
<script>

$(document).ready(function() {
	$('#remove-image').hide();
	removeImage();
	    
	$('#remove-image').click(function() {
		removeImage();
	});
	
    $('.image-upload').change(function() {
        ajaxFileUpload();
    });
});

function removeImage()
{
	$('#image-upload-thumbnail').attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAggAAAFoCAYAAAAy4AOkAAAcS0lEQVR4Xu3dB4/cVBcGYIcOondCEUJAQu+9/nR6gNBC7zV0CIgWQv2+M5KR12vvnYGT7OTex1Ik2Ll7x+c5K/kd+9qz48CBA393NgIECBAgQIDAQGCHgODvgQABAgQIEBgLCAj+JggQIECAAIFNAgKCPwoCBAgQIEBAQPA3QIAAAQIECJQFnEEoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpruYIJECBAgEBZQEAoGxlBgAABAgSaExAQmmu5ggkQIECAQFlAQCgbGUGAAAECBJoTEBCaa7mCCRAgQIBAWUBAKBsZQYAAAQIEmhMQEJpr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");
}

function ajaxFileUpload()
{
	$(document).ajaxStart( function() {
        $('#image-upload-thumbnail').attr('src', '/img/ajax/ajax-loader.gif');
    }).ajaxComplete(function(){
        removeImage();
    });
    
    $.ajaxFileUpload
    (
        {
        	url: "/ajax/image-upload",
            secureuri:false,
            fileElementId: "<?php echo $this->imageUploadId; ?>",
            dataType: 'json',
            success: function (data, status)
            {
            	$('#image-upload-thumbnail').attr("src", data.thumb);
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )
    
    return false;

} 
</script>
            <?php
        }
    }
    
    protected function openForm($title, $action)
    {
        echo('<div class="container">');
        echo('<legend>' . $title . '</legend>');
        
        $this->renderMessages();
        
        echo(
            '<form enctype="multipart/form-data" class="form-horizontal" ' .
                  'name="' . $this->form->getName() . '" ' .
                  'id="' . $this->form->getName() . '" ' .
                  'action="' . $action . '" ' .
                  'method="post">'
        );
    }
    
    protected function closeForm()
    {
        echo('</form>');
        
        echo('</div>');
    }
}
?>
