<?php
include_once __DIR__ . '/database/utils/getAll.php';

// Categories
$categories = getAll("SELECT * FROM categories");
// Marques
$brands = getAll("SELECT * FROM marques");
// dernieres produits
$last_products = getAll("SELECT * FROM produits ORDER BY id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/pages/includes/head.php' ?>
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="/src/css/index.css">
</head>

<body>
    <?php include_once __DIR__ . '/pages/includes/header.php' ?>
    <main>
        <div class="hero">
            <div class="imgs-container" id="imgs-container">
                <div class="img-container">
                    <img src="/assets/images/hero/living-room-2732939_1280.jpg" alt="">
                    <div class="text">
                        <h1>Meubles & décoration</h1>
                        <p>Decouvrez notre s lection de meubles et de decoration pour votre maison. Nous vous proposons une large gamme de produits pour am nager votre int rieur, du salon la chambre, en passant par la cuisine et le jardin. Nous avons des meubles et des d corations pour tous les styles et les budgets. Nous sommes s rs que vous trouverez ce que vous cherchez sur notre site.</p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>
                <div class="img-container">
                    <img src="/assets/images/hero/furniture-3208818_1280.jpg" alt="">
                    <div class="text">
                        <h1>Meubles & d coration</h1>
                        <p>Decouvrez notre s lection de meubles et de decoration pour votre maison. Nous vous proposons une large gamme de produits pour am nager votre int rieur, du salon la chambre, en passant par la cuisine et le jardin. Nous avons des meubles et des d corations pour tous les styles et les budgets. Nous sommes s rs que vous trouverez ce que vous cherchez sur notre site.</p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>
                <div class="img-container">
                    <img src="/assets/images/hero/home-5667532_1280.jpg" alt="">
                    <div class="text">
                        <h1>Meubles & d coration</h1>
                        <p>Decouvrez notre s lection de meubles et de decoration pour votre maison. Nous vous proposons une large gamme de produits pour am nager votre int rieur, du salon la chambre, en passant par la cuisine et le jardin. Nous avons des meubles et des d corations pour tous les styles et les budgets. Nous sommes s rs que vous trouverez ce que vous cherchez sur notre site.</p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>
                <div class="img-container">
                    <img src="/assets/images/hero/image.jpg" alt="">
                    <div class="text">
                        <h1>Meubles & d coration</h1>
                        <p>Decouvrez notre s lection de meubles et de decoration pour votre maison. Nous vous proposons une large gamme de produits pour am nager votre int rieur, du salon la chambre, en passant par la cuisine et le jardin. Nous avons des meubles et des d corations pour tous les styles et les budgets. Nous sommes s rs que vous trouverez ce que vous cherchez sur notre site.</p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>
                <div class="img-container">
                    <img src="/assets/images/hero/living-room-2569325_1280.jpg" alt="">
                    <div class="text">
                        <h1>Meubles & d coration</h1>
                        <p>Decouvrez notre s lection de meubles et de decoration pour votre maison. Nous vous proposons une large gamme de produits pour am nager votre int rieur, du salon la chambre, en passant par la cuisine et le jardin. Nous avons des meubles et des d corations pour tous les styles et les budgets. Nous sommes s rs que vous trouverez ce que vous cherchez sur notre site.</p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>
            </div>
            <div class="btns">
                <button type="button" id="last-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" id="next-btn">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <div class="points-container">
                <div class="points">
                    <div class="point active"></div>
                    <div class="point"></div>
                    <div class="point"></div>
                    <div class="point"></div>
                    <div class="point"></div>
                </div>
            </div>
        </div>
        <div class="categories-marques">
            <div class="text">
                <h1>Categories</h1>
                <p>Decouvrez nos differentes cat gories pour trouver facilement ce que vous cherchez. Nous avons des produits pour amenager votre interieur, votre exterieur, ainsi que des idees cadeaux pour vos proches.</p>
            </div>
            <div class="categorie-marques-container">
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <div class="categorie-marque">
                            <div class="image-title">
                                <div class="img-container">
                                    <img src="<?= $category['image_url'] ?>" alt="<?= $category['nom'] ?>">
                                </div>
                                <p><?= $category['nom'] ?></p>
                            </div>
                            <div class="desc">
                                <p><?= $category['description'] ?></p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucune categorie disponible. <?php if (isset($_SESSION['user']) && $_SESSION['user']['est_admin'] === 1) : ?> <a href="/pages/admin/?section=add-category">Ajouter une categorie</a><?php endif; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="about-us">
            <div class="text">
                <h5><i class="fa-solid fa-circle-info"></i> About us</h5>
                <h1>Dedicated to creating beautiful functional furniture for homes.</h1>
                <p>Quis adipiscing nec diam etiam urna et accumsan viverra velit. Nibh nunc est felis pharetra hac lorem. Dui imperdiet elit laoreet etiam nunc tempus turpis convallis venenatis.</p>
                <p>Vulputate nibh habitant duis cras ac pharetra purus. Vel vestibulum nulla in gravida. Egestas urna at habitasse viverra.</p>
                <a href="/pages/about-us.php">Discover More</a>
            </div>
            <div class="images">
                <div class="image1">
                    <img src="/assets/images/pages/index/6705993963deab2a01ddc20f_About Image 01-p-500.jpg" alt="">
                </div>
                <div class="image2">
                    <img src="/assets/images/pages/index/67059a0f1d8ee92ad3af283a_About Image 02-p-500.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="categories-marques">
            <div class="text">
                <h1>Marques</h1>
                <p>Lorem ipsum dolor sit amet cocipit, alias libero! Quam praesentium beatae expedita quo sapientit, eum alias, cum nesciunt suscipui aut.</p>
            </div>
            <div class="categorie-marques-container">
                <?php if (!empty($brands)) : ?>
                    <?php foreach ($brands as $brand) : ?>
                        <div class="categorie-marque">
                            <div class="image-title">
                                <div class="img-container">
                                    <img src="<?= $brand['logo_url'] ?>" alt="<?= $brand['nom'] ?>">
                                </div>
                                <p><?= $brand['nom'] ?></p>
                            </div>
                            <div class="desc">
                                <p><?= $brand['description'] ?></p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucune marque disponible pour le moment. <?php if (isset($_SESSION['user']) && $_SESSION['user']['est_admin'] === 1) : ?> <a href="?section=add-brand">Ajouter une marque</a><?php endif; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="derniers-produits">
            <h1>Derniers Produits</h1>
            <div class="container">
                <?php if (empty($last_products)) : ?>
                    <p>Aucun produit disponible pour le moment. <?php if (isset($_SESSION['user']) && $_SESSION['user']['est_admin'] === 1) : ?> <a href="/pages/admin/?section=add-category">Ajouter une categorie</a><?php endif; ?></p>
                <?php else : ?>
                    <?php foreach ($last_products as $product) : ?>
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
    <?php include_once __DIR__ . '/pages/includes/footer.php' ?>
    <script src="/src/js/index.js"></script>
</body>

</html>