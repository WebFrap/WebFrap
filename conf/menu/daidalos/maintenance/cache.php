<?php

  $this->files[] = array
  (
    'menu_mod_daidalos_clean_cache',
    Wgt::MAIN_TAB,
    I18n::s( 'Clean Cache', 'maintenance.label.cacheClean'  ),
    I18n::s( 'Clean Cache', 'maintenance.label.cacheClean'  ),
    'maintab.php?c=Maintenance.Cache.CleanAll',
    'daidalos/cache_clean.png',
  );