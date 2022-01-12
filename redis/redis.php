<?php
require ABSPATH . '/wp-content/themes/twentytwenty/vendor/autoload.php';
require_once ABSPATH . '/wp-load.php';

use Predis\Client;

/**
 * Plugin Name: redis
 * Plugin URI: http://innoshop.local.com/
 * Description: This is redis plugin for caching the database.
 * Version: 1.0
 * Author: Mohamed Mohsen
 * Author URI: http://innoshop.local.com/
 **/

function redis_caching()
{
    $redis = new Client();
    if (is_user_logged_in() == true) {
        $all_products = [];
        $cachedEntry = $redis->get('all_products');
        if ($cachedEntry) {
            /* Display data from Redis cache */
            $all_products = json_decode($cachedEntry);
        } else {
            /* Display data from DB */
            $args     = array('post_type' => 'product', 'posts_per_page' => -1);
            $products = get_posts($args);

            /* Save data to Redis */
            $redis->set('all_products', json_encode($products));
            // $redis->expire('all_products', 10);
            // $redis->flushAll();
        }

        /* Start draw the products */
        $all_html = "<style> @import url('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            color: #444444;
        }
        
        a,
        a:hover {
            text-decoration: none;
            color: inherit;
        }
        
        .section-products {
            padding: 40px 0 54px;
        }
        
        .section-products .header {
            margin-bottom: 50px;
        }
        
        .section-products .header h3 {
            font-size: 3rem;
            color: #cd2653;
            font-weight: 500;
        }
        
        .section-products .header h2 {
            font-size: 4.2rem;
            font-weight: 400;
            color: #444444; 
        }
        
        .section-products .single-product {
            margin-bottom: 26px;
        }
        
        .section-products .single-product .part-1 {
            position: relative;
            height: 200px;
            max-height: 290px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .section-products .single-product .part-1::before {
                position: absolute;
                content: '';
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                transition: all 0.3s;
        }
        
        .section-products .single-product:hover .part-1::before {
                transform: scale(1.2,1.2) rotate(5deg);
        }
        
        .section-products .part-1::before {
            background-size: cover;
                transition: all 0.3s;
        }
        
        .section-products .single-product .part-1 .discount,
        .section-products .single-product .part-1 .new {
            position: absolute;
            top: 15px;
            left: 0px;
            color: #ffffff;
            background-color: #fe302f;
            padding: 2px 8px;
            text-transform: uppercase;
            font-size: 1.85rem;
        }
        
        .section-products .single-product .part-1 .new {
            left: 0;
            background-color: #444444;

        }.section-products .single-product .part-1 img {
            height: 200px;
            max-height: 290px;
        }
        
        .section-products .single-product .part-1 ul li {
            display: inline-block;
            margin-right: 4px;
        }
        
        .section-products .single-product .part-1 ul li a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background-color: #ffffff;
            color: #444444;
            text-align: center;
            box-shadow: 0 2px 20px rgb(50 50 50 / 10%);
            transition: color 0.2s;
        }
        
        .section-products .single-product .part-1 ul li a:hover {
            color: #fe302f;
        }
        
        .section-products .single-product .part-2 .product-title {
            font-size: 2.25rem;
        }
        
        .section-products .single-product .part-2 h4 {
            display: inline-block;
            font-size: 1.8rem;
        }
        
        .section-products .single-product .part-2 .product-old-price {
            position: relative;
            padding: 0 7px;
            margin-right: 2px;
            opacity: 0.6;
        }
        
        .section-products .single-product .part-2 .product-old-price::after {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #444444;
            transform: translateY(-50%);
        }

        .added_to_cart{
            color: #cd2653;
            text-decoration: underline;
            font-size: 1.7rem;
            margin-left: 18%;
        }
        </style>
        <section class='section-products'>
    <div class='container'>
            <div class='row justify-content-center text-center'>
                    <div class='col-md-8 col-lg-6'>
                            <div class='header'>
                                    <h3>Featured Product</h3>
                                    <h2>Popular Products</h2>
                            </div>
                    </div>
            </div>
            <div class='row'>
           ";
        foreach ($all_products as $product) {
            $res = (array) $product;
            // $pro = new WC_product(18);
            $pro = new WC_product($res['ID']);
            $price = 0;
            $sale = 0;
            $new_price = 0;

            if (!empty($pro->get_regular_price())) {
                $price = $pro->get_regular_price();
                $sale = !empty($pro->get_sale_price()) ? 1 : 0;
                if ($pro->get_regular_price() > $pro->get_price()) {
                    $new_price = $pro->get_regular_price() - $pro->get_price();
                }
            } elseif (!empty($pro->get_sale_price())) {
                $price = $pro->get_sale_price();
                $sale = 1;
                if ($pro->get_regular_price() > $pro->get_sale_price()) {
                    $new_price = $pro->get_regular_price() - $pro->get_price();
                }
            } else {
                $price = $pro->get_price();
                $sale = !empty($pro->get_sale_price()) ? 1 : 0;
                if ($pro->get_regular_price() > $pro->get_price()) {
                    $new_price = $pro->get_regular_price() - $pro->get_price();
                }
            }

            // echo '<pre>';
            // var_dump($pro);
            // exit;
            if ($sale === 1) {
                $html = "
                    <div class='col-md-6 col-lg-4 col-xl-3'>
                            <div id='product-1' class='single-product'>
                                    <div class='part-1'>
                                       <span class='discount'>Sale</span>
                                    
                                        <a href='" . $res['guid'] . "'>
                                            <img src='" . wp_get_attachment_url($pro->get_image_id()) . "'>
                                        </a>
                                    </div>
                                    <div class='part-2'>
                                            <h3 class='product-title'>" . $pro->get_title() . "</h3>
                                            <h4 class='product-old-price'>" . $new_price . " EGP</h4>
                                            <h4 class='product-price'>" . $price . " EGP</h4>
                                    </div>
                                    <a href='?add-to-cart=" . $res['ID'] . "' data-quantity='1' 
                                    class='button product_type_simple add_to_cart_button ajax_add_to_cart'
                                    data-product_id='" . $res['ID'] . "' data-product_sku='" . $pro->get_sku() . "'
                                    aria-label='Add “Album” to your cart' 
                                    rel='nofollow'>Add to cart</a>
                            </div>
                    </div>
				";
                $all_html .= $html;
            }
            if ($sale === 0) {
                $html = "
                    <div class='col-md-6 col-lg-4 col-xl-3'>
                            <div id='product-1' class='single-product'>
                                    <div class='part-1'>                                    
                                        <a href='" . $res['guid'] . "'>
                                            <img src='" . wp_get_attachment_url($pro->get_image_id()) . "'>
                                        </a>
                                    </div>
                                    <div class='part-2'>
                                            <h3 class='product-title'>" . $pro->get_title() . "</h3>
                                            <h4 class='product-price'>" . $price . " EGP</h4>
                                    </div>
                                    <a href='?add-to-cart=" . $res['ID'] . "' data-quantity='1' 
                                    class='button product_type_simple add_to_cart_button ajax_add_to_cart'
                                    data-product_id='" . $res['ID'] . "' data-product_sku='" . $pro->get_sku() . "'
                                    aria-label='Add “Album” to your cart' 
                                    rel='nofollow'>Add to cart</a>
                            </div>
                    </div>
				";
                $all_html .= $html;
            }
        }
        $end = "</div></div>
        </section>";
        $all_html .= $html;
        echo ($all_html);
        /* End draw the products */

        //Flush data
        // $redis->flushAll();
    } else {
        /* Some other code */
    }
}


/* Display the products on Home Page only */
if ($_SERVER['REQUEST_URI'] === '/') {
    add_action('init', 'redis_caching');
}
