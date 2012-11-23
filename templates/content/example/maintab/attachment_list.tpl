<?php 


$commentTree = new WgtElementAttachmentList( 'fuu', $this  );
$commentTree->label = 'Attachments';
$commentTree->refId = Webfrap::$env->getUser()->getId();
$commentTree->id = 'example';
$commentTree->setData( $this->model->getAttachmentList( Webfrap::$env->getUser()->getId()  ) );

echo $ELEMENT->fuu;

?>