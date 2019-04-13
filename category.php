<?php get_header(); ?>
    <div class="catagory-items">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="top-texonomy">
                        <?php
                        $term = get_queried_object();
                        wp_reset_query();
                        $args = array('post_type' => 'news',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'posts_per_page' => 1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'news_category',
                                    'field' => 'slug',
                                    'terms' => $term->slug,
                                ),
                            ),
                        );

                        $loop = new WP_Query($args);
                        if($loop->have_posts()) {
                            while($loop->have_posts()) : $loop->the_post();
                                echo '<div class="texonomy-post">
                                        
                                        <div class="texonomy-post-content">
                                            <div>
                                                <div class="texonomy-content-box">
                                                    <h2 class="texonomy-post-title">
                                                        <a href="'.get_permalink().'">'.get_the_title().'</a>
                                                <p><span>'.get_the_date().'</span></p>

                                                    </h2>
                                                    
                                                </div>
                                                <div class="texonomy-img">
                                                    <a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>
                                                    <p class="texonomy-content">
                                                        '.substr( get_the_content(), 0, 350 ).'
                                                    </p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>';
                            endwhile;
                        }
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $term = get_queried_object();
                        wp_reset_query();
                        $args = array('post_type' => 'news',
                            'offset' => 1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'news_category',
                                    'field' => 'slug',
                                    'terms' => $term->slug,
                                ),
                            ),
                        );

                        $loop = new WP_Query($args);
                        if($loop->have_posts()) {
                            while($loop->have_posts()) : $loop->the_post();
                                echo'<div class="col-sm-6">
                                            <div class="texonomy-post-content">
                                                <a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>
                                                <h2 class="texonomy-post-title">
                                                    <a href="'.get_permalink().'">'.get_the_title().'</a>
                                                </h2>
                                                <span>'.get_the_date().'</span>
                                                <p class="texonomy-content">
                                                    '.substr( get_the_content(), 0, 350 ).'
                                                </p>
                                            </div>
                                        </div>';
                            endwhile;
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class=" sidebar top-stories">
                        <div class="sidebar-title">Popular Stories</div>
                        <ul class="news-list">
                            <?php
                            $args = array(
                                'post_type' => 'news',
                                'post_status' => 'publish',
                                'posts_per_page' =>4,
                                'order_by'=>'date',
                                'order'=>'DESC',
                                'meta_key' => 'wpb_post_views_count',
                                'orderby' => 'meta_value_num'
                            );
                            $loop = new WP_Query( $args );
                            while ( $loop->have_posts() ) : $loop->the_post();
                                ?>
                                <li>
                                    <div class="catt">
                                        <?php
                                        $terms = get_the_terms(get_the_ID(),'news_category' );
                                        if ( $terms && ! is_wp_error( $terms ) ) :

                                            $catt_links = array();

                                            foreach ( $terms as $term ) {
                                                $catt_links[] = $term->name;
                                            }

                                            $news_category = join( ", ", $catt_links );
                                            ?>

                                            <p class="news-category">
                                                <?php printf( esc_html__( '%s', 'textdomain' ), esc_html( $news_category ) ); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="latest-news-titles">
                                        <a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="posted-date">
                                        <i class="sm-icon-date">
                                        </i><?php the_time('F jS, Y'); ?>
                                    </div>
                                </li>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                    <div class="sidebar">
                        <div class="news-latest-list latest-list">
                            <div class="sidebar-title">Category</div>
                            <?php
                            $terms = get_terms(
                                array(
                                    'taxonomy'   => 'news_category',
                                    'hide_empty' => false,
                                )
                            );

                            // Check if any term exists
                            if ( ! empty( $terms ) && is_array( $terms ) ) {
                                // Run a loop and print them all
                                foreach ( $terms as $term ) { ?>
                                    <ul>
                                        <li>
                                            <a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
                                                <?php echo $term->name; ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="sidebar-block">
                            <div class="side-subscribe-section">
                                <?php echo do_shortcode('[subscribe_email layout="normal"]') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
