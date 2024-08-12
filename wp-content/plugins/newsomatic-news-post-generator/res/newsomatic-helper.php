<?php
   function newsomatic_helper()
   {
   
       $crawled_content = '';
       if(isset($_POST['newsomatic_crawl']) && isset($_POST['newsomatic_crawl_url']))
       {
           if (filter_var($_POST['newsomatic_crawl_url'], FILTER_VALIDATE_URL)) {
               $crawled_content = newsomatic_get_web_page($_POST['newsomatic_crawl_url']);
               if($crawled_content === false)
               {
                   $crawled_content = esc_html__('Error in page crawling. Please try again/other webpage.', 'newsomatic-news-post-generator');
               }
           }
           else
           {
               $crawled_content = esc_html__('Invalid URL provided: ', 'newsomatic-news-post-generator') . esc_url($_POST['newsomatic_crawl_url']);
           }
       }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <div>
         <div>
            <form method="post" onsubmit="return confirm('Are you sure you want to crawl this webpage?');">
               <h3>
                  <?php echo esc_html__("URL To Get Info From", 'newsomatic-news-post-generator');?>:
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Input the URL you want to get HTML Class, ID or XPATH from.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h3>
               <input name="newsomatic_crawl_url" type="url" validator="url" placeholder="URL to crawl" class="cr_width_full" value="<?php
                     if(isset($_POST['newsomatic_crawl_url']))
                     {
                         echo esc_url($_POST['newsomatic_crawl_url']);
                     }
                     if(isset($_POST['newsomatic_crawl_type']))
                     {
                         $newsomatic_crawl_type = $_POST['newsomatic_crawl_type'];
                     }
                     else
                     {
                         $newsomatic_crawl_type = '';
                     }
                     ?>"><br/><br/>
               <input name="newsomatic_crawl" type="submit" title="Submit for crawl" value="Crawl" class="cr_width_full">
               <br/><br/>
               <hr/>
               <h3>
                  <?php echo esc_html__("Query Type", 'newsomatic-news-post-generator');?>:
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Input the query type that you want to apply for the crawled article. This should be the same as the 'Query Type' settings field from the plugin settings.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h3>
               <select name="newsomatic_crawl_type" id="newsomatic_crawl_type" class="cr_width_full">
                  <option value="class"<?php if($newsomatic_crawl_type == 'class') echo ' selected';?>
                     ><?php echo esc_html__("Get Clicked Element HTML Class", 'newsomatic-news-post-generator');?></option>
                  <option value="id"<?php if($newsomatic_crawl_type == 'id') echo ' selected';?>
                     ><?php echo esc_html__("Get Clicked Element HTML ID", 'newsomatic-news-post-generator');?></option>
                  <option value="xpath"<?php if($newsomatic_crawl_type == 'xpath') echo ' selected';?>
                     ><?php echo esc_html__("Get Clicked Element XPATH Expression", 'newsomatic-news-post-generator');?></option>
               </select>
               <br/>
            </form>
         </div>
         <hr/>
         <?php
            if(isset($_POST['newsomatic_crawl_url']))
            {
            ?>
         <h3>
            <?php echo esc_html__("Crawled Content", 'newsomatic-news-post-generator');?>:
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("Here you can see the crawled webpage content.", 'newsomatic-news-post-generator');
                     ?>
               </div>
            </div>
         </h3>
         <br/>
         <div id="newsomatic_container" class="cr_helper">
            <?php
               $parsedUrl = parse_url($_POST['newsomatic_crawl_url']);
               $root = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
               $crawled_content = preg_replace('{=["\']/(\w)["\']}', '="' . esc_url($root) . '/$1"', $crawled_content);
               echo $crawled_content;
               ?>
         </div>
         <hr/>
         <?php
            }
            ?>
      </div>
   </div>
</div>
<?php
   }
   ?>