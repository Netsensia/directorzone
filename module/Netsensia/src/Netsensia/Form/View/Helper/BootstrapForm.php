<?php
namespace Netsensia\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Element\Submit;

class BootstrapForm extends AbstractHelper
{
    protected $form;
    protected $view;
    protected $options;
    
    private $hasImage;
    private $imageUploadId;
    private $imageLocationElementId;
    
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
            
            if ($element->getAttribute('data-netsensia') == 'image-upload') {
                $this->hasImage = true;
                $this->imageUploadId = $element->getAttribute('id');
                ?>
                <img id="image-upload-thumbnail" style="margin-top:1em; width: 100px; height: 100px;" src="">
                <div>
                <a id="remove-image" href="#">Remove Image</a>
                </div>
                <?php
            }
            
            if (strpos($element->getAttribute('data-netsensia'), 'image-upload-location') !== false) {
                $this->imageLocationElementId = $element->getAttribute('id');
            }
            
            $isInvisibleOther = (strpos($element->getAttribute('class'), 'invisible-other') !== false);
            $id = $element->getAttribute('id');
            
            if ($isInvisibleOther) {
                echo('<div id="' . $id . '" class="control-group invisible-other">');
            } else {
                echo('<div class="control-group" data-netsensia-group="' . $id . '">');
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

	var currentImageLocation = $('#<?php echo $this->imageLocationElementId; ?>').val();
	if (currentImageLocation != '') {
		$('#image-upload-thumbnail').attr("src", currentImageLocation);
	}
	
    $("[data-netsensia='image-upload']").change(function() {
        ajaxFileUpload();
    });
});

function removeImage()
{
	$('#image-upload-thumbnail').attr("src", "/img/ajax/camera.jpg");
}

function ajaxFileUpload()
{
	$(document).ajaxStart( function() {
        $('#image-upload-thumbnail').attr('src', '/img/ajax/ajax-loader.gif');
    }).ajaxComplete(function(){
        //removeImage();
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
            	$('#image-upload-thumbnail').attr('src', data.thumb);
            	$('#<?php echo $this->imageLocationElementId; ?>').val(data.main);
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
