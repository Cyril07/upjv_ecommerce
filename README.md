Sujet 4 : Le site de e-commerce
===============================

Le site permet de gérer un catalogue de produits et de les proposer à des clients. Le client peut passer des commandes, le commerçant accepte la commande en la livrant.

Cas d'utilisation
-----------------

Un client se connecte au site
-----------------------------

Il a la liste des articles proposés avec leur prix et le nombre de pièces dispos.

La liste des articles est paginée, triable par (prix, désignation, disponibilité)


Un client ajoute un article à son panier
----------------------------------------

Un articles s'ajoute au panier via un bouton icône présent à chaque article.

Si plus dispo l’icône est remplacé par un autre indiquant en cours de réappro.


Un client consulte son panier
-----------------------------

En haut de page est présent un lien pour accéder à son panier

Le panier est constitué de la liste des articles achetés

Le nombre de pièces commandées est modifiable

Le total apparaît en bas de la liste


Un client valide son panier
---------------------------

Formulaire à remplir , mail, nom, prénom

Après validation client et commerçant reçoivent le bon de commande


Le commerçant accède à l 'administration
----------------------------------------

Lien en bas de page, ouvrant une boite de dialogue pour l'authentification, boucle avec message d'erreur tant que pas bon log/pass (formulaire avec capcha)

Après authentification, arrivé sur page avec la liste des commandes à traiter (non livrées)

Menu à gauche : [ produits, clients, commandes ]


Le commerçant ajoute un produit
-------------------------------

Accès au formulaire d'ajout dans la page produits.

Les infos obligatoires sur le produit sont : désignation, description, prix, quantité


Le commerçant modifie un produit
--------------------------------

La page produit liste tous les produits.

La liste est paginée, sur chaque ligne produit on a un bouton modifié

Cliqué sur modifié bascule vers le même formulaire que l'ajout mais pré-remplis


Le commerçant supprime un produit
---------------------------------

Comme pour modif, chaque ligne a un bouton supprimé

Cliqué sur le bouton supprimé retire le produit du catalogue mais ne le supprime pas de la base


Le commerçant consulte ses commandes
------------------------------------

Accès à la liste de toutes les commandes par le menu

La liste est paginée.

Chaque ligne comporte les infos, [ clients, date , montant, état (livré oui/non) ]

La liste est triable, critère [a livré, livré, par date, par client]


Le commerçant envoie les produits
---------------------------------

Sur la page « home » commerçant accès à l'envoi à partir d'un bouton sur chaque ligne de commandes.

Sur la page « commande » bouton envoyé sur chaque ligne de commande non livrées

Envoi e-mail client pour signaler livraison.


Le commerçant consulte ses clients
----------------------------------

Accès à la liste de tous les clients par le menu

Liste des clients paginée.

Chaque ligne comporte [ Nom, e-mail, Montant total des commandes, Date dernière commande ]


Le commerçant se déconnecte de son compte
-----------------------------------------

En haut à droite déconnexion, il revient à la « home page » public