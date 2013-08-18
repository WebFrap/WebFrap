<?php 

/* @var $model WebfrapContactItem_Model */
$model = $this->loadModel( 'WebfrapContactItem' );
$user = Webfrap::$env->getUser();


try
{

  $contactList = new WgtElementContactItemList( 'fuu', $this  );
  $contactList->label = 'Contact Items';
  $contactList->setRefId( $user->getId() );
  $contactList->setIdKey( 'fubar' );

  $contactList->setData( $model->getItemList( $user->getId() ) );
  $contactList->typeData = $model->getItemTypeList();

  echo $ELEMENT->fuu;

}
catch( Exception $e )
{
  echo $e->getMessage();
}

?>