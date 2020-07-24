Wild-Circus

Installer le wild circus:
-git clone https://github.com/vara1991/Wild-Circus.git
-dans le fichier env met ton speudo/mot de passe/le nom de ta BDD
-composer install
-bin/console d:d:c
-bin/console d:m:m
-php bin/console doctrine:fixtures:load

Le client:
- Peut contacter l'admin 
- Réserver une séance
- Annuler une séance

Pour aller dans la page admin il faut:
- cliquer sur la petite étoile à droite dans le footer
- se loger
  - email : admin@gmail.com
  - mdp : 123456

L'admin :
- Peut ajouter/modifier/supprimer des spectacles 
- Peut ajouter/modifier/supprimer des artistes
- Peut ajouter/modifier/supprimer des séances
- Peut voir le nombre de place restante, le nom/prénom/email du spectateur

