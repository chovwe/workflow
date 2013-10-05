<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $int_profile  = new Int_Profile();
?>
    
<form name="frm_new_consultation" id="frm_new_consultation" method="post">
    <div class="outter_pad">
        <div style="margin: 20px;">
            <h2 style="padding: 0px; margin: 0px; color: #2d2d2d; font-size: 18px;">Consultation: (Patient Name)</h2>
        </div>
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Complaints:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">
                                <?php Form::hidden_field('patient_id', $session->get_patient_id()); ?>
                                <?php Form::textarea('complaint'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Other Observations:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">
                                <?php Form::textarea('observation'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Diagnosis:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">
                                <?php Form::textarea('diagnosis'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Plan/Procedure:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">
                                <?php Form::textarea('plan'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Extra Note:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">
                                <?php Form::textarea('note'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Controls:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2"><button type="submit">Save Notes</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function()
    {
        $init.equalize_heights(['#fieldset_contact','#fieldset_official']);
        $init.equalize_heights(['#fieldset_nok','#fieldset_other']);
    
        // Form        
        $("#frm_new_consultation").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
                    
            // Error flag
            var $no_error = true;
            
            // Serialize the form values
            var $form       = $(this).serializeArray();
            
            // Loop through the form values
            $.each($form, function( e, $form )
            {
                //alert($form.name + ' => ' + $form.value);
                var $div = $("#"+$form.name);
                
                if (($div.prop("validate") == "text") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;fill&nbsp;out&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
                
                else if (($div.prop("validate") == "select") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;select&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
            });
            
            if ($no_error)
            {
                // Create an instance of the FormData() object to assemble form elements
                var formData = new FormData($("#frm_new_consultation")[0]);
                formData.append('opt', 'consultation');
                formData.append('complaint', $("#complaint").val());
                formData.append('observation', $("#observation").val());
                formData.append('diagnosis', $("#diagnosis").val());
                formData.append('plan', $("#plan").val());
                formData.append('note', $("#note").val());
                
                $.ajax({
                    url: "../calls/includes/switch.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",                
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function($json)
                    {
                        if($json.status == "true")
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_successful',width:'200',height:'120',buttons:'NNY'});
                            $file_loader.load_middle_pane('patients/patient_consultation');
                            $file_loader.load_left_pane('patients/patient_menu');
                        }
                        else
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
                        }
                    },
                    error: function(request, status, error)
                    {
                        //alert(request.responseText);
                        $ui_engine.block({title:'Alert!',file:'alert_connection',width:'200',height:'120',buttons:'NNY'});
                    }
                });
            }
        });
        editor = $("#complaint, #observation, #diagnosis, #plan, #note").ckeditor().editor;
        
        editor.config.toolbar =
        [
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] }
        ];
        
        editor = $("#observation").ckeditor().editor;
        
        editor.config.toolbar =
        [
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] }
        ];
        
        editor = $("#diagnosis").ckeditor().editor;
        
        editor.config.toolbar =
        [
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] }
        ];
        
        editor = $("#plan").ckeditor().editor;
        
        editor.config.toolbar =
        [
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] }
        ];
        
        editor = $("#note").ckeditor().editor;
        
        editor.config.toolbar =
        [
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] }
        ];
    });
</script>