<?php
return array(
    'view_helpers' => array(
        'invokables' => array(
            'pageHeader' => 'Components\Layout\View\Helper\Header',
            'form' => 'Components\Form\View\Helper\Form',
            'formRow' => 'Components\Form\View\Helper\FormRow',
            'formButton' => 'Components\Form\View\Helper\FormButton',
            'formActions' => 'Components\Form\View\Helper\FormActions',
            'FormElementErrors' => 'Components\Form\View\Helper\FormElementErrors',
        ),
    ),

    'form_elements' => array(
        'invokables' => array(
            'submitButton' => 'Components\Form\Element\SubmitButton',
            'cancelButton' => 'Components\Form\Element\CancelButton'
        )
    )
);