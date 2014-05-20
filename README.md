. Joomla plugin to include an html list of publications from Hal directly in your website
==========

## How does it works ? ##

This plugin creates a new filter which can be activated or not.

Once installed, create a new article and copy this tag modele in the content:

`{{ type="webpage_from_hal" url="http://hal.univ-grenoble-alpes.fr/Public/afficheRequetePubli.php?auteur_exp=boris,morel&CB_auteur=oui&CB_titre=oui&CB_article=oui&langue=Francais&tri_exp=annee_publi&tri_exp2=typdoc&tri_exp3=date_publi&ordre_aff=TA&Fen=Aff&css=../css/VisuRubriqueEncadre.css"}}`

By this filter, Joomla gets the url content and replaces the tag section with the html content directly in the body.
Text before and after the tag section is preserved. Several tag
sections are allowed in an article.

## Install ##
  1. To install the plugin, refer to the official [Joomla documentation](http://docs.joomla.org/Installing_an_extension).

## Activate ##
  1. Plugin must be enabled before it will work.
  
## Support ##

GitHub is the good way to contribute on this project.
  - Issue
  - Pull request
  - [...]

