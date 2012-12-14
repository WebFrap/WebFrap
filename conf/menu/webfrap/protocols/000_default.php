<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
  array( 'Protocols', $this->interface.'?c=Webfrap.Base.menu&amp;menu=protocols','control/folder.png'),
);

$this->firstEntry = array
  (
    'menu-mod-webfrap-maintenance',
    Wgt::MAIN_TAB,
    '..',
    I18n::s( 'System', 'maintenance.label'  ),
    'maintab.php?c=Webfrap.Base.menu&amp;menu=maintenance',
    'places/folder.png',
  );

$this->files[] = array
(
  'menu-system-protocols-login',
  Wgt::MAIN_TAB,
  'Logon Protocol',
  'Logon Protocol',
  'maintab.php?c=Wbfsys.ProtocolUsage.listing',
  'utilities/protocol.png',
);

$this->files[] = array
(
  'menu-system-protocols-messages',
  Wgt::MAIN_TAB,
  'Mesage Protocol',
  'Mesage Protocol',
  'maintab.php?c=Wbfsys.MessageLog.listing',
  'utilities/protocol.png',
);

$this->files[] = array
(
  'menu-system-protocols-usage',
  Wgt::MAIN_TAB,
  'Usage Protocol',
  'Usage Protocol',
  'maintab.php?c=Wbfsys.ProtocolMessage.listing',
  'utilities/protocol.png',
);