<?php 


$commentTree = new WgtElementCommentTree( 'fuu', $this  );
$commentTree->label = 'Comments';
$commentTree->refId = Webfrap::$env->getUser()->getId();
$commentTree->id = 'example';
$commentTree->setData( $this->model->getCommentTree( Webfrap::$env->getUser()->getId()  ) );

echo $ELEMENT->fuu;

?>