 <?php
 include_once __DIR__ . '/../database/utils/getAll.php';
 
 $produits = getAll("SELECT * FROM produits");
 ?>
 <!DOCTYPE html>
 <html lang="fr">

 <head>
     <?php include_once __DIR__ . '/includes/head.php' ?>
     <title>Produits</title>
     <link rel="stylesheet" href="/src/css/produits.css">
 </head>

 <body>
     <?php include_once __DIR__ . '/includes/header.php' ?>
     <main>
         <div class="produits">
             <h1>Derniers Produits</h1>
             <div class="container">
                 <?php if (empty($produits)) : ?>
                     <p>Aucun produit disponible pour le moment. <?php if (isset($_SESSION['user']) && $_SESSION['user']['est_admin'] === 1) : ?> <a href="/pages/admin/?section=add-category">Ajouter une categorie</a><?php endif; ?></p>
                 <?php else : ?>
                     <?php foreach ($produits as $product) : ?>
                         <?php
                            // une image de chaque produit
                            $images = getAll("SELECT * FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $product['id']]);
                            $product['image_url'] = $images[0]['img_url'];
                            ?>
                         <a class="produit" href="/pages/produit-review.php?id=<?= $product['id'] ?>">
                             <div class="img-produit">
                                 <img src="<?= $product['image_url'] ?>" alt="">
                             </div>
                             <div class="info">
                                 <h1><?= $product['nom'] ?></h1>
                                 <div class="conteneur-prix">
                                     <p class="ancien-prix"><?= $product['ancien_prix'] ?> Dhs</p>
                                     <p class="nouveau-prix"><?= $product['prix'] ?> Dhs</p>
                                     <span class="remise"><?= round(100 - ($product['prix'] / $product['ancien_prix']) * 100) ?>%</span>
                                 </div>
                             </div>
                         </a>
                     <?php endforeach; ?>
                 <?php endif; ?>
             </div>
         </div>
     </main>
     <?php include_once __DIR__ . '/includes/footer.php' ?>
 </body>

 </html>