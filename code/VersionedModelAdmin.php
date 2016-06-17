<?php

/**
 * Class VersionedModelAdmin
 */
class VersionedModelAdmin extends ModelAdmin
{
    private static $allowed_actions = array(
        'HistoryForm',
    );

    /**
     * Customise the edit form so that It uses the VersionedDataObjectDetailsForm as well as make
     * sure that the reading stage is 'Stage'.
     * @param null $id
     * @param null $fields
     * @return mixed
     */
    public function getEditForm($id = null, $fields = null)
    {
        // get the third parameter without changing the signiture so it stays the same as the base class.
        $args = func_get_args();
        $isHistory = isset($args[2]) ? $args[2] : false;

        VersionedReadingMode::setStageReadingMode();

        $list = $this->getList();
        $exportButton = new GridFieldExportButton('buttons-before-left');
        $exportButton->setExportColumns($this->getExportFields());

        // create the appropriate detail form
        $editForm = $isHistory ? new VersionedDataObjectHistoryForm() : new VersionedDataObjectDetailsForm();

        $listField = GridField::create(
            $this->sanitiseClassName($this->modelClass),
            false,
            $list,
            $fieldConfig = GridFieldConfig_RecordEditor::create($this->stat('page_length'))
                ->addComponent($exportButton)
                ->removeComponentsByType('GridFieldFilterHeader')
                ->removeComponentsByType('GridFieldDeleteAction')
                ->addComponents(new GridFieldPrintButton('buttons-before-left'))
                ->removeComponentsByType('GridFieldDetailForm')
                ->addComponent($editForm)
        );

        // Validation
        if (singleton($this->modelClass)->hasMethod('getCMSValidator')) {
            $detailValidator = singleton($this->modelClass)->getCMSValidator();
            $listField->getConfig()->getComponentByType('GridFieldDetailForm')->setValidator($detailValidator);
        }

        $form = CMSForm::create(
            $this,
            'EditForm',
            new FieldList($listField),
            new FieldList()
        )->setHTMLID('Form_EditForm');
        $form->setResponseNegotiator($this->getResponseNegotiator());
        $form->addExtraClass('cms-edit-form cms-panel-padded center');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));

        // post to the correct URL.
        $editAction = $isHistory ? 'HistoryForm' : 'EditForm';
        $editFormAction = Controller::join_links($this->Link($this->sanitiseClassName($this->modelClass)), $editAction);

        $form->setFormAction($editFormAction);
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        $this->extend('updateEditForm', $form);

        VersionedReadingMode::restoreOriginalReadingMode();

        return $form;
    }

    public function HistoryForm($request = null) {
        // pass an extra parameter to specify that we want the history detail form.
        return $this->getEditForm(null, null, true);
    }
}