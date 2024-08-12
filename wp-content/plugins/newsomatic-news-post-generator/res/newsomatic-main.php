<?php
   
   function newsomatic_admin_settings()
   {
       $language_names = array(
           esc_html__("Disabled", 'newsomatic-news-post-generator'),
           esc_html__("Afrikaans (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Albanian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Arabic (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Amharic (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Armenian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Belarusian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Bulgarian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Catalan (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Chinese Simplified (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Croatian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Czech (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Danish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Dutch (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("English (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Estonian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Filipino (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Finnish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("French (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Galician (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("German (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Greek (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hebrew (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hindi (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hungarian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Icelandic (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Indonesian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Irish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Italian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Japanese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Korean (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Latvian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Lithuanian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Norwegian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Macedonian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Malay (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Maltese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Persian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Polish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Portuguese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Romanian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Russian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Serbian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Slovak (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Slovenian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Spanish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Swahili (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Swedish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Thai (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Turkish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Ukrainian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Vietnamese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Welsh (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Yiddish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Tamil (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Azerbaijani (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Kannada (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Basque (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Bengali (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Latin (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Chinese Traditional (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Esperanto (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Georgian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Telugu (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Gujarati (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Haitian Creole (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Urdu (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Burmese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Bosnian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Cebuano (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Chichewa (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Corsican (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Frisian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Scottish Gaelic (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hausa (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hawaian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Hmong (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Igbo (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Javanese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Kazakh (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Khmer (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Kurdish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Kyrgyz (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Lao (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Luxembourgish (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Malagasy (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Malayalam (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Maori (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Marathi (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Mongolian (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Nepali (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Pashto (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Punjabi (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Samoan (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Sesotho (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Shona (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Sindhi (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Sinhala (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Somali (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Sundanese (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Swahili (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Tajik (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Uzbek (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Xhosa (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Yoruba (Google Translate)", 'newsomatic-news-post-generator'),
           esc_html__("Zulu (Google Translate)", 'newsomatic-news-post-generator')
       );
       $language_codes = array(
           "disabled",
           "af",
           "sq",
           "ar",
           "am",
           "hy",
           "be",
           "bg",
           "ca",
           "zh-CN",
           "hr",
           "cs",
           "da",
           "nl",
           "en",
           "et",
           "tl",
           "fi",
           "fr",
           "gl",
           "de",
           "el",
           "iw",
           "hi",
           "hu",
           "is",
           "id",
           "ga",
           "it",
           "ja",
           "ko",
           "lv",
           "lt",
           "no",
           "mk",
           "ms",
           "mt",
           "fa",
           "pl",
           "pt",
           "ro",
           "ru",
           "sr",
           "sk",
           "sl",
           "es",
           "sw",
           "sv",   
           "th",
           "tr",
           "uk",
           "vi",
           "cy",
           "yi",
           "ta",
           "az",
           "kn",
           "eu",
           "bn",
           "la",
           "zh-TW",
           "eo",
           "ka",
           "te",
           "gu",
           "ht",
           "ur",
           
           "my",
           "bs",
           "ceb",
           "ny",
           "co",
           "fy",
           "gd",
           "ha",
           "haw",
           "hmn",
           "ig",
           "jw",
           "kk",
           "km",
           "ku",
           "ky",
           "lo",
           "lb",
           "mg",
           "ml",
           "mi",
           "mr",
           "mn",
           "ne",
           "ps",
           "pa",
           "sm",
           "st",
           "sn",
           "sd",
           "si",
           "so",
           "su",
           "sw",
           "tg",
           "uz",
           "xh",
           "yo",
           "zu"
       );
       $language_names_deepl = array(
         "English (DeepL)",
         "German (DeepL)",
         "French (DeepL)",
         "Spanish (DeepL)",
         "Italian (DeepL)",
         "Dutch (DeepL)",
         "Polish (DeepL)",
         "Russian (DeepL)",
         "Portuguese (DeepL)",
         "Chinese (DeepL)",
         "Japanese (DeepL)",
         "Bulgarian (DeepL)",
         "Czech (DeepL)",
         "Danish (DeepL)",
         "Greek (DeepL)",
         "Estonian (DeepL)",
         "Finnish (DeepL)",
         "Hungarian (DeepL)",
         "Lithuanian (DeepL)",
         "Latvian (DeepL)",
         "Romanian (DeepL)",
         "Slovak (DeepL)",
         "Slovenian (DeepL)",
         "Swedish (DeepL)"
         );
         $language_codes_deepl = array(
            "EN-",
            "DE-",
            "FR-",
            "ES-",
            "IT-",
            "NL-",
            "PL-",
            "RU-",
            "PT-",
            "ZH-",
            "JA-",
            "BG-",
            "CS-",
            "DA-",
            "EL-",
            "ET-",
            "FI-",
            "HU-",
            "LT-",
            "LV-",
            "RO-",
            "SK-",
            "SL-",
            "SV-"
         );
         $language_names_bing = array(
          "English (Microsoft Translator)",
          "Arabic (Microsoft Translator)",
          "Bosnian (Latin) (Microsoft Translator)",
          "Bulgarian (Microsoft Translator)",
          "Catalan (Microsoft Translator)",
          "Chinese Simplified (Microsoft Translator)",
          "Chinese Traditional (Microsoft Translator)",
          "Croatian (Microsoft Translator)",
          "Czech (Microsoft Translator)",
          "Danish (Microsoft Translator)",
          "Dutch (Microsoft Translator)",
          "Estonian (Microsoft Translator)",
          "Finnish (Microsoft Translator)",
          "French (Microsoft Translator)",
          "German (Microsoft Translator)",
          "Greek (Microsoft Translator)",
          "Haitian Creole (Microsoft Translator)",
          "Hebrew (Microsoft Translator)",
          "Hindi (Microsoft Translator)",
          "Hmong Daw (Microsoft Translator)",
          "Hungarian (Microsoft Translator)",
          "Indonesian (Microsoft Translator)",
          "Italian (Microsoft Translator)",
          "Japanese (Microsoft Translator)",
          "Kiswahili (Microsoft Translator)",
          "Klingon (Microsoft Translator)",
          "Klingon (pIqaD) (Microsoft Translator)",
          "Korean (Microsoft Translator)",
          "Latvian (Microsoft Translator)",
          "Lithuanian (Microsoft Translator)",
          "Malay (Microsoft Translator)",
          "Maltese (Microsoft Translator)",
          "Norwegian (Microsoft Translator)",
          "Persian (Microsoft Translator)",
          "Polish (Microsoft Translator)",
          "Portuguese (Microsoft Translator)",
          "Queretaro Otomi (Microsoft Translator)",
          "Romanian (Microsoft Translator)",
          "Russian (Microsoft Translator)",
          "Serbian (Cyrillic) (Microsoft Translator)",
          "Serbian (Latin) (Microsoft Translator)",
          "Slovak (Microsoft Translator)",
          "Slovenian (Microsoft Translator)",
          "Spanish (Microsoft Translator)",
          "Swedish (Microsoft Translator)",
          "Thai (Microsoft Translator)",
          "Turkish (Microsoft Translator)",
          "Ukrainian (Microsoft Translator)",
          "Urdu (Microsoft Translator)",
          "Vietnamese (Microsoft Translator)",
          "Welsh (Microsoft Translator)",
          "Yucatec Maya (Microsoft Translator)"
          );
          $language_codes_bing = array(
              "en!",
              "ar!",
              "bs-Latn!",
              "bg!",
              "ca!",
              "zh-CHS!",
              "zh-CHT!",
              "hr!",
              "cs!",
              "da!",
              "nl!",
              "et!",
              "fi!",
              "fr!",
              "de!",
              "el!",
              "ht!",
              "he!",
              "hi!",
              "mww!",
              "hu!",
              "id!",
              "it!",
              "ja!",
              "sw!",
              "tlh!",
              "tlh-Qaak!",
              "ko!",
              "lv!",
              "lt!",
              "ms!",
              "mt!",
              "nor!",
              "fa!",
              "pl!",
              "pt!",
              "otq!",
              "ro!",
              "ru!",
              "sr-Cyrl!",
              "sr-Latn!",
              "sk!",
              "sl!",
              "es!",
              "sv!",
              "th!",
              "tr!",
              "uk!",
              "ur!",
              "vi!",
              "cy!",
              "yua!"
          );
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<div>
<form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
   <div class="cr_autocomplete">
      <input type="password" id="PreventChromeAutocomplete" 
         name="PreventChromeAutocomplete" autocomplete="address-level4" />
   </div>
   <?php
      settings_fields('newsomatic_option_group');
      do_settings_sections('newsomatic_option_group');
      $newsomatic_Main_Settings = get_option('newsomatic_Main_Settings', false);
      if (isset($newsomatic_Main_Settings['newsomatic_enabled'])) {
          $newsomatic_enabled = $newsomatic_Main_Settings['newsomatic_enabled'];
      } else {
          $newsomatic_enabled = '';
      }
      if (isset($newsomatic_Main_Settings['enable_metabox'])) {
          $enable_metabox = $newsomatic_Main_Settings['enable_metabox'];
      } else {
          $enable_metabox = '';
      }
      if (isset($newsomatic_Main_Settings['disable_dmca'])) {
          $disable_dmca = $newsomatic_Main_Settings['disable_dmca'];
      } else {
          $disable_dmca = '';
      }
      if (isset($newsomatic_Main_Settings['no_new_tab'])) {
          $no_new_tab = $newsomatic_Main_Settings['no_new_tab'];
      } else {
          $no_new_tab = '';
      }
      if (isset($newsomatic_Main_Settings['phantom_path'])) {
          $phantom_path = $newsomatic_Main_Settings['phantom_path'];
      } else {
          $phantom_path = '';
      }
      if (isset($newsomatic_Main_Settings['phantom_timeout'])) {
          $phantom_timeout = $newsomatic_Main_Settings['phantom_timeout'];
      } else {
          $phantom_timeout = '';
      }
      if (isset($newsomatic_Main_Settings['sentence_list'])) {
          $sentence_list = $newsomatic_Main_Settings['sentence_list'];
      } else {
          $sentence_list = '';
      }
      if (isset($newsomatic_Main_Settings['sentence_list2'])) {
          $sentence_list2 = $newsomatic_Main_Settings['sentence_list2'];
      } else {
          $sentence_list2 = '';
      }
      if (isset($newsomatic_Main_Settings['user_agent'])) {
          $user_agent = $newsomatic_Main_Settings['user_agent'];
      } else {
          $user_agent = '';
      }
      if (isset($newsomatic_Main_Settings['variable_list'])) {
          $variable_list = $newsomatic_Main_Settings['variable_list'];
      } else {
          $variable_list = '';
      }
      if (isset($newsomatic_Main_Settings['enable_detailed_logging'])) {
          $enable_detailed_logging = $newsomatic_Main_Settings['enable_detailed_logging'];
      } else {
          $enable_detailed_logging = '';
      }
      if (isset($newsomatic_Main_Settings['enable_logging'])) {
          $enable_logging = $newsomatic_Main_Settings['enable_logging'];
      } else {
          $enable_logging = '';
      }
      if (isset($newsomatic_Main_Settings['auto_clear_logs'])) {
          $auto_clear_logs = $newsomatic_Main_Settings['auto_clear_logs'];
      } else {
          $auto_clear_logs = '';
      }
      if (isset($newsomatic_Main_Settings['rule_timeout'])) {
          $rule_timeout = $newsomatic_Main_Settings['rule_timeout'];
      } else {
          $rule_timeout = '';
      }
      if (isset($newsomatic_Main_Settings['strip_links'])) {
          $strip_links = $newsomatic_Main_Settings['strip_links'];
      } else {
          $strip_links = '';
      }
      if (isset($newsomatic_Main_Settings['fix_html'])) {
          $fix_html = $newsomatic_Main_Settings['fix_html'];
      } else {
          $fix_html = '';
      }
      if (isset($newsomatic_Main_Settings['new_category'])) {
          $new_category = $newsomatic_Main_Settings['new_category'];
      } else {
          $new_category = '';
      }
      if (isset($newsomatic_Main_Settings['links_hide'])) {
          $links_hide = $newsomatic_Main_Settings['links_hide'];
      } else {
          $links_hide = '';
      }
      if (isset($newsomatic_Main_Settings['apiKey'])) {
          $apiKey = $newsomatic_Main_Settings['apiKey'];
      } else {
          $apiKey = '';
      }
      if (isset($newsomatic_Main_Settings['skip_no_class'])) {
          $skip_no_class = $newsomatic_Main_Settings['skip_no_class'];
      } else {
          $skip_no_class = '';
      }
      if (isset($newsomatic_Main_Settings['no_import_full'])) {
          $no_import_full = $newsomatic_Main_Settings['no_import_full'];
      } else {
          $no_import_full = '';
      }
      if (isset($newsomatic_Main_Settings['no_import_no_class'])) {
          $no_import_no_class = $newsomatic_Main_Settings['no_import_no_class'];
      } else {
          $no_import_no_class = '';
      }
      if (isset($newsomatic_Main_Settings['strip_scripts'])) {
          $strip_scripts = $newsomatic_Main_Settings['strip_scripts'];
      } else {
          $strip_scripts = '';
      }
      if (isset($newsomatic_Main_Settings['send_email'])) {
          $send_email = $newsomatic_Main_Settings['send_email'];
      } else {
          $send_email = '';
      }
      if (isset($newsomatic_Main_Settings['request_delay'])) {
          $request_delay = $newsomatic_Main_Settings['request_delay'];
      } else {
          $request_delay = '';
      }
      if (isset($newsomatic_Main_Settings['email_address'])) {
          $email_address = $newsomatic_Main_Settings['email_address'];
      } else {
          $email_address = '';
      }
      if (isset($newsomatic_Main_Settings['rel_canonical'])) {
          $rel_canonical = $newsomatic_Main_Settings['rel_canonical'];
      } else {
          $rel_canonical = '';
      }
      if (isset($newsomatic_Main_Settings['meta_noindex'])) {
          $meta_noindex = $newsomatic_Main_Settings['meta_noindex'];
      } else {
          $meta_noindex = '';
      }
      if (isset($newsomatic_Main_Settings['shortest_api'])) {
          $shortest_api = $newsomatic_Main_Settings['shortest_api'];
      } else {
          $shortest_api = '';
      }
      if (isset($newsomatic_Main_Settings['link_source'])) {
          $link_source = $newsomatic_Main_Settings['link_source'];
      } else {
          $link_source = '';
      }
      if (isset($newsomatic_Main_Settings['date_format'])) {
          $date_format = $newsomatic_Main_Settings['date_format'];
      } else {
          $date_format = '';
      }
      if (isset($newsomatic_Main_Settings['translate'])) {
          $translate = $newsomatic_Main_Settings['translate'];
      } else {
          $translate = '';
      }
      if (isset($newsomatic_Main_Settings['translate_source'])) {
          $translate_source = $newsomatic_Main_Settings['translate_source'];
      } else {
          $translate_source = '';
      }
      if (isset($newsomatic_Main_Settings['spin_text'])) {
          $spin_text = $newsomatic_Main_Settings['spin_text'];
      } else {
          $spin_text = '';
      }
      if (isset($newsomatic_Main_Settings['google_trans_auth'])) {
          $google_trans_auth = $newsomatic_Main_Settings['google_trans_auth'];
      } else {
          $google_trans_auth = '';
      }
      if (isset($newsomatic_Main_Settings['best_user'])) {
          $best_user = $newsomatic_Main_Settings['best_user'];
      } else {
          $best_user = '';
      }
      if (isset($newsomatic_Main_Settings['no_title_spin'])) {
          $no_title_spin = $newsomatic_Main_Settings['no_title_spin'];
      } else {
          $no_title_spin = '';
      }
      if (isset($newsomatic_Main_Settings['exclude_words_title'])) {
          $exclude_words_title = $newsomatic_Main_Settings['exclude_words_title'];
      } else {
          $exclude_words_title = '';
      }
      if (isset($newsomatic_Main_Settings['spin_lang'])) {
          $spin_lang = $newsomatic_Main_Settings['spin_lang'];
      } else {
          $spin_lang = '';
      }
      if (isset($newsomatic_Main_Settings['wordai_uniqueness'])) {
          $wordai_uniqueness = $newsomatic_Main_Settings['wordai_uniqueness'];
      } else {
          $wordai_uniqueness = '';
      }
      if (isset($newsomatic_Main_Settings['exclude_words'])) {
          $exclude_words = $newsomatic_Main_Settings['exclude_words'];
      } else {
          $exclude_words = '';
      }
      if (isset($newsomatic_Main_Settings['best_password'])) {
          $best_password = $newsomatic_Main_Settings['best_password'];
      } else {
          $best_password = '';
      }
      if (isset($newsomatic_Main_Settings['min_word_title'])) {
          $min_word_title = $newsomatic_Main_Settings['min_word_title'];
      } else {
          $min_word_title = '';
      }
      if (isset($newsomatic_Main_Settings['max_word_title'])) {
          $max_word_title = $newsomatic_Main_Settings['max_word_title'];
      } else {
          $max_word_title = '';
      }
      if (isset($newsomatic_Main_Settings['min_word_content'])) {
          $min_word_content = $newsomatic_Main_Settings['min_word_content'];
      } else {
          $min_word_content = '';
      }
      if (isset($newsomatic_Main_Settings['max_word_content'])) {
          $max_word_content = $newsomatic_Main_Settings['max_word_content'];
      } else {
          $max_word_content = '';
      }
      if (isset($newsomatic_Main_Settings['required_words'])) {
          $required_words = $newsomatic_Main_Settings['required_words'];
      } else {
          $required_words = '';
      }
      if (isset($newsomatic_Main_Settings['banned_words'])) {
          $banned_words = $newsomatic_Main_Settings['banned_words'];
      } else {
          $banned_words = '';
      }
      if (isset($newsomatic_Main_Settings['skip_old'])) {
          $skip_old = $newsomatic_Main_Settings['skip_old'];
      } else {
          $skip_old = '';
      }
      if (isset($newsomatic_Main_Settings['skip_day'])) {
          $skip_day = $newsomatic_Main_Settings['skip_day'];
      } else {
          $skip_day = '';
      }
      if (isset($newsomatic_Main_Settings['skip_month'])) {
          $skip_month = $newsomatic_Main_Settings['skip_month'];
      } else {
          $skip_month = '';
      }
      if (isset($newsomatic_Main_Settings['skip_year'])) {
          $skip_year = $newsomatic_Main_Settings['skip_year'];
      } else {
          $skip_year = '';
      }
      if (isset($newsomatic_Main_Settings['custom_html2'])) {
          $custom_html2 = $newsomatic_Main_Settings['custom_html2'];
      } else {
          $custom_html2 = '';
      }
      if (isset($newsomatic_Main_Settings['custom_html'])) {
          $custom_html = $newsomatic_Main_Settings['custom_html'];
      } else {
          $custom_html = '';
      }
      if (isset($newsomatic_Main_Settings['skip_no_img'])) {
          $skip_no_img = $newsomatic_Main_Settings['skip_no_img'];
      } else {
          $skip_no_img = '';
      }
      if (isset($newsomatic_Main_Settings['strip_by_id'])) {
          $strip_by_id = $newsomatic_Main_Settings['strip_by_id'];
      } else {
          $strip_by_id = '';
      }
      if (isset($newsomatic_Main_Settings['strip_by_class'])) {
          $strip_by_class = $newsomatic_Main_Settings['strip_by_class'];
      } else {
          $strip_by_class = '';
      }
      if (isset($newsomatic_Main_Settings['read_more'])) {
          $read_more = $newsomatic_Main_Settings['read_more'];
      } else {
          $read_more = '';
      }
      if (isset($newsomatic_Main_Settings['deepl_auth'])) {
          $deepl_auth = $newsomatic_Main_Settings['deepl_auth'];
      } else {
          $deepl_auth = '';
      }
      if (isset($newsomatic_Main_Settings['bing_auth'])) {
          $bing_auth = $newsomatic_Main_Settings['bing_auth'];
      } else {
          $bing_auth = '';
      }
      if (isset($newsomatic_Main_Settings['bing_region'])) {
          $bing_region = $newsomatic_Main_Settings['bing_region'];
      } else {
          $bing_region = '';
      }
      if (isset($newsomatic_Main_Settings['deppl_free'])) {
          $deppl_free = $newsomatic_Main_Settings['deppl_free'];
      } else {
          $deppl_free = '';
      }
      if (isset($newsomatic_Main_Settings['newsomatic_app_id'])) {
          $newsomatic_app_id = $newsomatic_Main_Settings['newsomatic_app_id'];
      } else {
          $newsomatic_app_id = '';
      }
      if (isset($newsomatic_Main_Settings['app_id'])) {
          $app_id = $newsomatic_Main_Settings['app_id'];
      } else {
          $app_id = '';
      }
      if (isset($newsomatic_Main_Settings['newsapi_active'])) {
          $newsapi_active = $newsomatic_Main_Settings['newsapi_active'];
      } else {
          $newsapi_active = '';
      }
      if (isset($newsomatic_Main_Settings['resize_width'])) {
          $resize_width = $newsomatic_Main_Settings['resize_width'];
      } else {
          $resize_width = '';
      }
      if (isset($newsomatic_Main_Settings['strip_featured_image'])) {
          $strip_featured_image = $newsomatic_Main_Settings['strip_featured_image'];
      } else {
          $strip_featured_image = '';
      }
      if (isset($newsomatic_Main_Settings['no_local_image'])) {
          $no_local_image = $newsomatic_Main_Settings['no_local_image'];
      } else {
          $no_local_image = '';
      }
      if (isset($newsomatic_Main_Settings['url_image'])) {
          $url_image = $newsomatic_Main_Settings['url_image'];
      } else {
          $url_image = '';
      }
      if (isset($newsomatic_Main_Settings['resize_height'])) {
          $resize_height = $newsomatic_Main_Settings['resize_height'];
      } else {
          $resize_height = '';
      }
      if (isset($newsomatic_Main_Settings['copy_images'])) {
          $copy_images = $newsomatic_Main_Settings['copy_images'];
      } else {
          $copy_images = '';
      }
      if (isset($newsomatic_Main_Settings['do_not_check_duplicates'])) {
          $do_not_check_duplicates = $newsomatic_Main_Settings['do_not_check_duplicates'];
      } else {
          $do_not_check_duplicates = '';
      }
      if (isset($newsomatic_Main_Settings['title_duplicates'])) {
          $title_duplicates = $newsomatic_Main_Settings['title_duplicates'];
      } else {
          $title_duplicates = '';
      }
      if (isset($newsomatic_Main_Settings['headlessbrowserapi_key'])) {
          $headlessbrowserapi_key = $newsomatic_Main_Settings['headlessbrowserapi_key'];
      } else {
          $headlessbrowserapi_key = '';
      }
      if (isset($newsomatic_Main_Settings['no_check'])) {
          $no_check = $newsomatic_Main_Settings['no_check'];
      } else {
          $no_check = '';
      }
      if (isset($newsomatic_Main_Settings['draft_first'])) {
          $draft_first = $newsomatic_Main_Settings['draft_first'];
      } else {
          $draft_first = '';
      }
      if (isset($newsomatic_Main_Settings['max_query'])) {
          $max_query = $newsomatic_Main_Settings['max_query'];
      } else {
          $max_query = '';
      }
      if (isset($newsomatic_Main_Settings['custom_ciphers'])) {
          $custom_ciphers = $newsomatic_Main_Settings['custom_ciphers'];
      } else {
          $custom_ciphers = '';
      }
      if (isset($newsomatic_Main_Settings['secret_word'])) {
          $secret_word = $newsomatic_Main_Settings['secret_word'];
      } else {
          $secret_word = '';
      }
      if (isset($newsomatic_Main_Settings['require_all'])) {
          $require_all = $newsomatic_Main_Settings['require_all'];
      } else {
          $require_all = '';
      }
      if (isset($newsomatic_Main_Settings['no_link_translate'])) {
          $no_link_translate = $newsomatic_Main_Settings['no_link_translate'];
      } else {
          $no_link_translate = '';
      }
      if (isset($newsomatic_Main_Settings['skip_failed_tr'])) {
          $skip_failed_tr = $newsomatic_Main_Settings['skip_failed_tr'];
      } else {
          $skip_failed_tr = '';
      }
      if (isset($newsomatic_Main_Settings['litte_translate'])) {
          $litte_translate = $newsomatic_Main_Settings['litte_translate'];
      } else {
          $litte_translate = '';
      }
      if (isset($newsomatic_Main_Settings['proxy_auth'])) {
          $proxy_auth = $newsomatic_Main_Settings['proxy_auth'];
      } else {
          $proxy_auth = '';
      }
      if (isset($newsomatic_Main_Settings['proxy_url'])) {
          $proxy_url = $newsomatic_Main_Settings['proxy_url'];
      } else {
          $proxy_url = '';
      }
      
      if (isset($newsomatic_Main_Settings['scrapeimg_height'])) {
          $scrapeimg_height = $newsomatic_Main_Settings['scrapeimg_height'];
      } else {
          $scrapeimg_height = '';
      }
      if (isset($newsomatic_Main_Settings['attr_text'])) {
          $attr_text = $newsomatic_Main_Settings['attr_text'];
      } else {
          $attr_text = '';
      }
      if (isset($newsomatic_Main_Settings['scrapeimg_width'])) {
          $scrapeimg_width = $newsomatic_Main_Settings['scrapeimg_width'];
      } else {
          $scrapeimg_width = '';
      }
      if (isset($newsomatic_Main_Settings['scrapeimg_cat'])) {
          $scrapeimg_cat = $newsomatic_Main_Settings['scrapeimg_cat'];
      } else {
          $scrapeimg_cat = '';
      }
      if (isset($newsomatic_Main_Settings['scrapeimg_order'])) {
          $scrapeimg_order = $newsomatic_Main_Settings['scrapeimg_order'];
      } else {
          $scrapeimg_order = '';
      }
      if (isset($newsomatic_Main_Settings['scrapeimg_orientation'])) {
          $scrapeimg_orientation = $newsomatic_Main_Settings['scrapeimg_orientation'];
      } else {
          $scrapeimg_orientation = '';
      }
      if (isset($newsomatic_Main_Settings['imgtype'])) {
          $imgtype = $newsomatic_Main_Settings['imgtype'];
      } else {
          $imgtype = '';
      }
      if (isset($newsomatic_Main_Settings['img_order'])) {
          $img_order = $newsomatic_Main_Settings['img_order'];
      } else {
          $img_order = '';
      }
      if (isset($newsomatic_Main_Settings['scrapeimgtype'])) {
          $scrapeimgtype = $newsomatic_Main_Settings['scrapeimgtype'];
      } else {
          $scrapeimgtype = '';
      }
      if (isset($newsomatic_Main_Settings['pixabay_scrape'])) {
          $pixabay_scrape = $newsomatic_Main_Settings['pixabay_scrape'];
      } else {
          $pixabay_scrape = '';
      }
      if (isset($newsomatic_Main_Settings['img_editor'])) {
          $img_editor = $newsomatic_Main_Settings['img_editor'];
      } else {
          $img_editor = '';
      }
      if (isset($newsomatic_Main_Settings['img_language'])) {
          $img_language = $newsomatic_Main_Settings['img_language'];
      } else {
          $img_language = '';
      }
      if (isset($newsomatic_Main_Settings['unsplash_api'])) {
          $unsplash_api = $newsomatic_Main_Settings['unsplash_api'];
      } else {
          $unsplash_api = '';
      }
      if (isset($newsomatic_Main_Settings['img_ss'])) {
          $img_ss = $newsomatic_Main_Settings['img_ss'];
      } else {
          $img_ss = '';
      }
      if (isset($newsomatic_Main_Settings['img_mwidth'])) {
          $img_mwidth = $newsomatic_Main_Settings['img_mwidth'];
      } else {
          $img_mwidth = '';
      }
      if (isset($newsomatic_Main_Settings['img_width'])) {
          $img_width = $newsomatic_Main_Settings['img_width'];
      } else {
          $img_width = '';
      }
      if (isset($newsomatic_Main_Settings['img_cat'])) {
          $img_cat = $newsomatic_Main_Settings['img_cat'];
      } else {
          $img_cat = '';
      }
      if (isset($newsomatic_Main_Settings['pixabay_api'])) {
          $pixabay_api = $newsomatic_Main_Settings['pixabay_api'];
      } else {
          $pixabay_api = '';
      }
      if (isset($newsomatic_Main_Settings['pexels_api'])) {
          $pexels_api = $newsomatic_Main_Settings['pexels_api'];
      } else {
          $pexels_api = '';
      }
      if (isset($newsomatic_Main_Settings['morguefile_secret'])) {
          $morguefile_secret = $newsomatic_Main_Settings['morguefile_secret'];
      } else {
          $morguefile_secret = '';
      }
      if (isset($newsomatic_Main_Settings['morguefile_api'])) {
          $morguefile_api = $newsomatic_Main_Settings['morguefile_api'];
      } else {
          $morguefile_api = '';
      }
      if (isset($newsomatic_Main_Settings['bimage'])) {
          $bimage = $newsomatic_Main_Settings['bimage'];
      } else {
          $bimage = '';
      }
      if (isset($newsomatic_Main_Settings['no_orig'])) {
          $no_orig = $newsomatic_Main_Settings['no_orig'];
      } else {
          $no_orig = '';
      }
      if (isset($newsomatic_Main_Settings['flickr_order'])) {
          $flickr_order = $newsomatic_Main_Settings['flickr_order'];
      } else {
          $flickr_order = '';
      }
      if (isset($newsomatic_Main_Settings['flickr_license'])) {
          $flickr_license = $newsomatic_Main_Settings['flickr_license'];
      } else {
          $flickr_license = '';
      }
      if (isset($newsomatic_Main_Settings['flickr_api'])) {
          $flickr_api = $newsomatic_Main_Settings['flickr_api'];
      } else {
          $flickr_api = '';
      }
      $get_option_viewed = get_option('coderevolution_settings_viewed', 0);
      if ($get_option_viewed == 0) {
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo sprintf( wp_kses( __( 'Did you see our new <a href="%s" target="_blank">recommendations page</a>? It will help you increase your passive earnings!', 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'admin.php?page=newsomatic_recommendations' ) );?></strong></p>
   </div>
   <?php
      }
      if (isset($_GET['settings-updated'])) {
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'newsomatic-news-post-generator');?></strong></p>
   </div>
   <?php
      $get = get_option('coderevolution_settings_changed', 0);
      if($get == 1)
      {
          delete_option('coderevolution_settings_changed');
      ?>
   <div id="message" class="updated">
      <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration failed!', 'newsomatic-news-post-generator');?></strong></p>
   </div>
   <?php 
      }
      elseif($get == 2)
      {
              delete_option('coderevolution_settings_changed');
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration successful!', 'newsomatic-news-post-generator');?></strong></p>
   </div>
   <?php 
      }
      elseif($get != 0)
      {
              delete_option('coderevolution_settings_changed');
      ?>
   <div id="message" class="updated">
      <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html($get);?></strong></p>
   </div>
   <?php 
      }
          }
      ?>
   <div>
   <div class="newsomatic_class">
      <table class="widefat">
         <tr>
            <td>
               <h1>
                  <span class="gs-sub-heading"><b>Newsomatic Automatic Post Generator Plugin - <?php echo esc_html__('Main Switch:', 'newsomatic-news-post-generator');?></b>&nbsp;</span>
                  <span class="cr_07_font">v<?php echo newsomatic_get_version();?>&nbsp;</span>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Enable or disable this plugin. This acts like a main switch.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h1>
            </td>
            <td>
               <div class="slideThree">	
                  <input class="input-checkbox" type="checkbox" id="newsomatic_enabled" name="newsomatic_Main_Settings[newsomatic_enabled]"<?php
                     if ($newsomatic_enabled == 'on')
                         echo ' checked ';
                     ?>>
                  <label for="newsomatic_enabled"></label>
               </div>
            </td>
         </tr>
      </table>
   </div>
   <div><?php if($newsomatic_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'newsomatic-news-post-generator') . '</div>';}?>
      <table class="widefat">
         <tr>
            <td colspan="2">
               <?php
                  $plugin = plugin_basename(__FILE__);
                  $plugin_slug = explode('/', $plugin);
                  $plugin_slug = $plugin_slug[0]; 
                  $uoptions = get_option($plugin_slug . '_registration', array());
                  if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
                  {
                  ?>
               <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'newsomatic-news-post-generator');?></b> </h3>
               <ul>
                  <li><b><?php echo esc_html__("Item Name:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                  <li>
                     <b><?php echo esc_html__("Item ID:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['item_id']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Created At:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['created_at']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Buyer Name:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['buyer']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("License Type:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['licence']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Supported Until:", 'newsomatic-news-post-generator');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                  </li>
                  <li>
                     <input type="submit" onclick="unsaved = false;" class="button button-primary" name="<?php echo esc_html($plugin_slug);?>_revoke_license" value="<?php echo esc_html__("Revoke License", 'newsomatic-news-post-generator');?>">
                  </li>
               </ul>
               <?php
                  }
                  else
                  {
                  ?>
               <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("This is a trial version of the plugin. Automatic updates for this plugin are disabled. Please activate the plugin from below, so you can benefit of automatic updates for it!", 'newsomatic-news-post-generator');?></b></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Register Envato Purchase Code To Enable Automatic Updates:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td><input type="text" name="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'newsomatic-news-post-generator');?>"></td>
         </tr>
         <tr>
            <td></td>
            <td><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Register Purchase Code", 'newsomatic-news-post-generator');?>"/>
               <?php
                  }
                  ?>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
      <tr><td>
      <h3><?php echo esc_html__("Tips for using the plugin:", 'newsomatic-news-post-generator');?></h3>
         <ul>
            <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.youtube.com/watch?v=avxe6UAWJOQ&list=PLEiGTaa0iBIi-LWwOcsZDnWZcG8FtuYGs&index=1' ) );?>
            </li>
            <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact <a href="%s" target="_blank">our support</a>!', 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base' ), esc_url('//coderevolution.ro/support' ) );?></li>
            <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or check <a href="%s" target="_blank">our website</a>  for other cool plugins.', 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//codecanyon.net/downloads' ), esc_url( 'https://coderevolution.ro' ) );?></a></li>
            <li><span class="cr_color_red"><?php echo esc_html__("Are you looking for a cool new theme that best fits this plugin?", 'newsomatic-news-post-generator');?></span> <a onclick="revealRec()" class="cr_cursor_pointer"><?php echo esc_html__("Click here for our theme related recommendation", 'newsomatic-news-post-generator');?></a>.
               <br/><span id="diviIdrec"></span>
            </li>
         </ul>
<?php
	if ($newsapi_active != 'on')
    {
      if($newsomatic_app_id == '' && $_SERVER['HTTP_HOST'] == 'wpinitiate.com')
      {
?>
      <h3>
         <br/><br/><span class="cr_color_red"><?php echo esc_html__("You are on the demo site for the Newsomatic plugin, only here, you can test the plugin using the below API key (50 API request limit):", 'newsomatic-news-post-generator');?></span> <b><i>newsomaticapitestnewsomaticapitestnewsomaticapitestnewsomaticapite</i></b>
      </h3>
<?php
      }
	}
?>
      </td></tr>
	      <tr class="cr_none">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to switch to NewsAPI instead of NewsomaticAPI? This settings is for testing purposes only.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Switch to NewsAPI", 'newsomatic-news-post-generator');?></a>:</b>
               </div>
            </td>
            <td>
               <div>
                  <input type="checkbox" id="newsapi_active" name="newsomatic_Main_Settings[newsapi_active]"<?php
               if ($newsapi_active == 'on')
                   echo ' checked ';
               ?>>
               </div>
            </td>
         </tr>
         <tr>
             <td colspan="2">
                <h3><?php echo esc_html__("API Key Setup:", 'newsomatic-news-post-generator');?></h3>
             </td>
          </tr>
          <tr>
            
<?php
if ($newsapi_active != 'on')
{
?>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your NewsomaticAPI API Key. Get one <a href='%s' target='_blank'>here</a>. Alternatively, you can also use an API key from RapidAPI, after you subscribed to <a href='%s' target='_blank'>NewsomaticAPI on RapidAPI</a>.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://newsomaticapi.com/register' ), esc_url( 'https://rapidapi.com/caddytzitzy/api/newsomaticapi' ) );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red12"><a href='https://newsomaticapi.com/register' target='_blank'><?php echo esc_html__("NewsomaticAPI API Key:", 'newsomatic-news-post-generator');?></a></b>
                  <?php
                  $call_count = get_option('newsomaticapi_calls', false);
                  if($newsomatic_app_id != '' && $call_count !== false && $call_count != '-1')
                  {
                     echo esc_html__("Remaining API Calls For Today: ", 'newsomatic-news-post-generator') . '<b>' . $call_count . '</b>';
                  }
                  ?>    
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="newsomatic_app_id" name="newsomatic_Main_Settings[newsomatic_app_id]" value="<?php
                     echo esc_html($newsomatic_app_id);
                     ?>" placeholder="<?php echo esc_html__("Please insert your NewsomaticAPI API Key", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
<?php
}
else
{
	?>
         
         <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your NewsAPI API Key. Get one <a href='%s' target='_blank'>here</a>.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://newsapi.org/register' ) );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red12"><a href='https://newsapi.org/register' target='_blank'><?php echo esc_html__("NewsAPI API Key:", 'newsomatic-news-post-generator');?></a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="app_id" name="newsomatic_Main_Settings[app_id]" value="<?php
                     echo esc_html($app_id);
                     ?>" placeholder="<?php echo esc_html__("Please insert your NewsAPI API Key", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
<?php
}
?>
         
         <tr>
             <td colspan="2">
                <h3><?php echo esc_html__("Other API Keys:", 'newsomatic-news-post-generator');?></h3>
             </td>
          </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to use Microsoft for translation, you must enter first a Microsoft 'Access Key'. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Automatically Translate Content To' and 'Source Language' fields.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/" target="_blank"><?php echo esc_html__("Microsoft Translator Access Key (Optional)", 'newsomatic-news-post-generator');?>:</a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="bing_auth" placeholder="<?php echo esc_html__("Access key (optional)", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[bing_auth]" value="<?php
                     echo esc_html($bing_auth);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you selected a specific region in your Azure Microsoft account, you must enter it here. Learn more <a href='%s' target='_blank'>here</a>. The default is global.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/" target="_blank"><?php echo esc_html__("Microsoft Translator Region Code (Optional)", 'newsomatic-news-post-generator');?>:</a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="bing_region" placeholder="<?php echo esc_html__("global", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[bing_region]" value="<?php
                     echo esc_html($bing_region);
                     ?>"/>
               </div>
            </td>
         </tr>
          <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to use DeepL for translation, you must enter first a DeepL 'Authentication Key'. Get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Automatically Translate Content To' and 'Source Language' fields.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.deepl.com/subscription.html' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="https://www.deepl.com/subscription.html" target="_blank"><?php echo esc_html__("DeepL Translator Authentication Key (Optional)", 'newsomatic-news-post-generator');?>:</a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="deepl_auth" placeholder="<?php echo esc_html__("Auth key (optional)", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[deepl_auth]" value="<?php
                     echo esc_html($deepl_auth);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Check this checkbox if the above API key is a DeepL free plan key. If it is a PRO key, please uncheck this checkbox.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("The Above Is A DeepL Free API Key:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="deppl_free" name="newsomatic_Main_Settings[deppl_free]"<?php
               if ($deppl_free == 'on')
                  echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
             <td colspan="2">
                <h3><?php echo esc_html__("Scraping Enhancements:", 'newsomatic-news-post-generator');?></h3>
             </td>
          </tr>
          <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to use the HeadlessBrowserAPI to render JavaScript generated content for your scraped pages, enter your API key here. Get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Use PhantomJs/Puppeteer/Tor To Parse JavaScript On Pages' in importing rule settings.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'http://headlessbrowserapi.com/pricing/' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="http://headlessbrowserapi.com/" target="_blank"><?php echo esc_html__("HeadlessBrowserAPI Key (Optional)", 'newsomatic-news-post-generator');?>:</a></b>
                          <?php
                           $call_count = get_option('headless_calls', false);
                           if($headlessbrowserapi_key != '' && $call_count !== false)
                           {
                              echo esc_html__("Remaining API Calls For Today: ", 'newsomatic-news-post-generator') . '<b>' . $call_count . '</b>';
                           }
                          ?>
                          <div class="cr_float_right bws_help_box bws_help_box_right dashicons cr_align_middle"><img class="cr_align_middle" src="<?php echo plugins_url('../images/new.png', __FILE__);?>" alt="new feature"/>
                                              <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("New feature added to this plugin: it is able to use HeadlessBrowserAPI to scrape with JavaScript rendered content any website from the internet. Also, the Tor node of the API will be able to scrape .onion sites from the Dark Net!", 'newsomatic-news-post-generator');?>
                                              </div>
                                           </div>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="headlessbrowserapi_key" placeholder="<?php echo esc_html__("API key", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[headlessbrowserapi_key]" value="<?php
                     echo esc_html($headlessbrowserapi_key);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td></td>
            <td><br/><input type="submit" name="btnSubmitApp" id="btnSubmitApp" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Info", 'newsomatic-news-post-generator');?>"/>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("After you entered a NewsomaticAPI Key, you can start creating rules:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td><a name="newest" href="admin.php?page=newsomatic_items_panel">- News -> <?php echo esc_html__("Blog Posts", 'newsomatic-news-post-generator');?> -</a></td>
            <td>
               (using NewsomaticAPI's <strong>API</strong>)
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Posts will be generated from the latest entries in NewsomaticAPI's public feed.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Plugin Options:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to skip checking for duplicate posts when publishing new posts (check this if you have 10000+ posts on your blog and you are experiencing slowdows when the plugin is running. If you check this, duplicate posts will be posted! So use it only when it is necesarry.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Check For Duplicate Posts:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="do_not_check_duplicates" name="newsomatic_Main_Settings[do_not_check_duplicates]"<?php
               if ($do_not_check_duplicates == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to check duplicate posts by title instead of URL.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Check Duplicate Posts By Title Instead of URL:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="title_duplicates" name="newsomatic_Main_Settings[title_duplicates]"<?php
               if ($title_duplicates == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Check this to force the plugin not check generated posts in rule settings. Improves performance if you have 100k posts generated using this plugin.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Do Not Check Generated Posts In Rule Settings:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
               <input type="checkbox" id="no_check" name="newsomatic_Main_Settings[no_check]"<?php
                  if ($no_check == 'on')
                      echo ' checked ';
                  ?>>
            </td>
         </tr>
         <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to force the plugin to make draft posts before they would be fully published. This can help you you use other third party plugins with the automatically published posts.", 'newsomatic-news-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Draft Posts First, And Publish Them Afterwards:", 'newsomatic-news-post-generator');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="draft_first" name="newsomatic_Main_Settings[draft_first]"<?php
                           if ($draft_first == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Set if the plugin should query NewsomaticAPI with maximum sized requests. If you uncheck this checkbox, the plugin will query the API strictly with the queried post count.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Query As Many Post As Possible From NewsomaticAPI:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
               <input type="checkbox" id="max_query" name="newsomatic_Main_Settings[max_query]"<?php
                  if ($max_query == 'on')
                      echo ' checked ';
                  ?>>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("This is a debug feature (experimental). Input a cipher list, if you get this (or similar) error in curl requests: 'gnutls_handshake() failed: A TLS packet with unexpected length was received.'", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Allow Custom Ciphers In Curl Requests:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
               <input type="text" id="custom_ciphers" placeholder="<?php echo esc_html__("Input a cipher list", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[custom_ciphers]" value="<?php
                  echo esc_html($custom_ciphers);
                  ?>"/>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select a secret word that will be used when you run the plugin manually/by cron. See details about this below.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Secret Word Used For Manual/Cron Running:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="text" id="secret_word" name="newsomatic_Main_Settings[secret_word]" value="<?php echo esc_html($secret_word);?>" placeholder="<?php echo esc_html__("Input a secret word", 'newsomatic-news-post-generator');?>">
            </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div>
                  <br/><b><?php echo esc_html__("If you want to schedule the cron event manually in your server, you should schedule this address:", 'newsomatic-news-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo get_site_url() . '/?run_newsomatic=' . urlencode($secret_word);} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'newsomatic-news-post-generator'); }?></span><br/><?php echo esc_html__("Example:", 'newsomatic-news-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo '15,45****wget -q -O /dev/null ' . get_site_url() . '/?run_newsomatic=' . urlencode($secret_word);} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'newsomatic-news-post-generator'); }?></span></b>
               </div>
               <br/><br/>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose this option if you do not want to open links created by the %%item_read_more_button%% shortcode in a new tab.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Open 'Read More' Links In a New Tab:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_new_tab" name="newsomatic_Main_Settings[no_new_tab]"<?php
               if ($no_new_tab == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose this option if you wish to import content from any source - by default, the plugin will filter (and not import content from) sources that are know to make DMCA take down requests for their reposted content. Currently on the 'no import' list: onemileatatime.com", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Disable DMCA Protection:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="disable_dmca" name="newsomatic_Main_Settings[disable_dmca]"<?php
               if ($disable_dmca == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to show an extended information metabox under every plugin generated post.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Show Extended Item Information Metabox in Post:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="enable_metabox" name="newsomatic_Main_Settings[enable_metabox]"<?php
               if ($enable_metabox == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
          <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to use the official version of the Google Translator API for translation, you must enter first a Google API Key. Get one <a href='%s' target='_blank'>here</a>.  Please enable the 'Cloud Translation API' in <a href='%s' target='_blank'>Google Cloud Console</a>. Translation will work even without even without entering an API key here, but in this case, an unofficial Google Translate API will be used.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://console.cloud.google.com/apis/credentials' ), esc_url( 'https://console.cloud.google.com/marketplace/browse?q=translate' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo esc_html__("Google Translator API Key (Optional)", 'newsomatic-news-post-generator');?>:</a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="google_trans_auth" placeholder="<?php echo esc_html__("API Key (optional)", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[google_trans_auth]" value="<?php
                     echo esc_html($google_trans_auth);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable logging for rules?", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable Logging for Rules:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="enable_logging" name="newsomatic_Main_Settings[enable_logging]" onclick="mainChanged()"<?php
               if ($enable_logging == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <input type="checkbox" id="enable_detailed_logging" name="newsomatic_Main_Settings[enable_detailed_logging]"<?php
                     if ($enable_detailed_logging == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Clear Logs After:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <select class="cr_width_full" id="auto_clear_logs" name="newsomatic_Main_Settings[auto_clear_logs]" >
                     <option value="No"<?php
                        if ($auto_clear_logs == "No") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Disabled", 'newsomatic-news-post-generator');?></option>
                     <option value="monthly"<?php
                        if ($auto_clear_logs == "monthly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a month", 'newsomatic-news-post-generator');?></option>
                     <option value="weekly"<?php
                        if ($auto_clear_logs == "weekly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a week", 'newsomatic-news-post-generator');?></option>
                     <option value="daily"<?php
                        if ($auto_clear_logs == "daily") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a day", 'newsomatic-news-post-generator');?></option>
                     <option value="twicedaily"<?php
                        if ($auto_clear_logs == "twicedaily") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Twice a day", 'newsomatic-news-post-generator');?></option>
                     <option value="hourly"<?php
                        if ($auto_clear_logs == "hourly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once an hour", 'newsomatic-news-post-generator');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the user-agent to use when downloading web pages.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("User-Agent To Use When Getting Web Pages:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="user_agent" placeholder="<?php echo esc_html__("Input a user agent", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[user_agent]" value="<?php
                     echo esc_html($user_agent);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("If you want to use a proxy to crawl webpages, input it's address here. Required format: IP Address/URL:port. You can input a comma separated list of proxies. If you are using HeadlessBrowserAPI, add 'disabled' into this field to disable automatic proxy rotation of the API.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Web Proxy Address List:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="proxy_url" placeholder="<?php echo esc_html__("Input web proxy url", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[proxy_url]" value="<?php echo esc_html($proxy_url);?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("If you want to use a proxy to crawl webpages, and it requires authentification, input it's authentification details here. You can input a comma separated list of users/passwords. If a proxy does not have a user/password, please leave it blank in the list. Example: user1:pass1,user2:pass2,,user4:pass4.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Web Proxy Authentification:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="proxy_auth" placeholder="<?php echo esc_html__("Input web proxy auth", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[proxy_auth]" value="<?php echo esc_html($proxy_auth);?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the timeout (in seconds) for every rule running. I recommend that you leave this field at it's default value (3600).", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Timeout for Rule Running (seconds):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="rule_timeout" step="1" min="0" class="cr_width_full" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[rule_timeout]" value="<?php
                     echo esc_html($rule_timeout);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the timeout (in milliseconds) between each subsequent call to the crawled website. Increase this value if the website has a anti-crawling mechanism active. Here you can also input a pair of values, separated by a comma (ex: 300,500). In this case, a random timeout will be selected, between the two values you specified. This is a global timeout, will be applied to all created importing rules, however, this will be overwritten by the \'Delay Between Multiple Requests\' from each importing rule settings", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Delay Between Multiple Requests - Global Settings - (milliseconds):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="request_delay" placeholder="<?php echo esc_html__("Input request delay", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[request_delay]" value="<?php echo esc_html($request_delay);?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="send_email" name="newsomatic_Main_Settings[send_email]" onchange="mainChanged()"<?php
               if ($send_email == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideMail">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Email Address:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideMail">
                  <input type="email" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[email_address]" value="<?php
                     echo esc_html($email_address);
                     ?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Post Content Options:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <?php
               if($shortest_api == '')
               {
                   echo '<td colspan="2"><span><b>To enable outgoing link monetization, <a href="http://join-shortest.com/ref/ff421f2b06?user-type=new" target="_blank">sign up for a Shorte.st account here</a></b>. To get your API token after you have signed up, click <a href="https://shorte.st/tools/api?user-type=new" target="_blank">here</a>.</span><br/></td></tr><tr>';
               }
               ?>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to shorten outgoing links using shorte.st, please enter your API token here. To sign up for a new account, click <a href='%s' target='_blank'>here</a>. To get your API token after you have signed up, click <a href='%s' target='_blank'>here</a>. To disable URL shortening, leave this field blank.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "http://join-shortest.com/ref/ff421f2b06?user-type=new" ), esc_url( 'https://shorte.st/tools/api?user-type=new'));
                           ?>
                     </div>
                  </div>
                  <b><a href="http://join-shortest.com/ref/ff421f2b06?user-type=new" target="_blank"><?php echo esc_html__("Shorte.st API Token", 'newsomatic-news-post-generator');?></a>:</b>
            </td>
            <td>
            <input type="text" name="newsomatic_Main_Settings[shortest_api]" value="<?php
               echo esc_html($shortest_api);
               ?>" placeholder="<?php echo esc_html__("Shorte.st API token", 'newsomatic-news-post-generator');?>">
            </div>
            </td>
         </tr>
         <tr>
             <td>
                <div>
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo esc_html__("Choose if you want to automatically shorten URLs using Bitly URL shortener.", 'newsomatic-news-post-generator');
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("Automatically Shorten URLs Using Bit.ly:", 'newsomatic-news-post-generator');?></b>
             </td>
             <td>
             <input type="checkbox" id="links_hide" name="newsomatic_Main_Settings[links_hide]" onchange="mainChanged();"<?php
                if ($links_hide == 'on')
                    echo ' checked ';
                ?>>
             </div>
             </td>
          </tr>
          <tr>
             <td>
                <div class="hideGoo">
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("Bitly API Generic Access Token:", 'newsomatic-news-post-generator');?></b>
                </div>
             </td>
             <td>
                <div class="hideGoo">
                   <input type="password" name="newsomatic_Main_Settings[apiKey]" value="<?php echo esc_html($apiKey);?>" placeholder="<?php echo esc_html__("Please insert your Bitly API Generic Access Token", 'newsomatic-news-post-generator');?>">
                </div>
             </td>
          </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to link generated post titles to source articles. This option will be overwritten if you set it also from rule settings.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Link Generated Post Titles To Source Articles:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="link_source" name="newsomatic_Main_Settings[link_source]"<?php
               if ($link_source == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to add a 'rel=canonical' meta tag to generated posts, linking back to the source of the article.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Add \"rel=canonical\" Meta Tag To Generated Posts:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="rel_canonical" name="newsomatic_Main_Settings[rel_canonical]"<?php
               if ($rel_canonical == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to add a <meta name='robots' content='noindex,follow'/> meta tag to generated posts, telling search engines to not index the posts generated by this plugin.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Add Noindex Robots Meta Tag To Generated Posts:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="meta_noindex" name="newsomatic_Main_Settings[meta_noindex]"<?php
               if ($meta_noindex == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Set the date format for the %%item_date%% shortcode. Example: Y-m-d H:i:s . You can read more about date formats, <a href='%s' target='_blank'>here</a>. To leave this at it's default value, leave this field blank.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'http://php.net/manual/ro/function.date.php' ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Date Format for the %%item_date%% Shortcode:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="text" id="date_format" name="newsomatic_Main_Settings[date_format]" placeholder="<?php echo esc_html__("Add a date format", 'newsomatic-news-post-generator');?>" value="<?php echo esc_html($date_format);?>">
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to skip full content importing for posts that don't have the class/id defined in the 'HTML Search Query String' rule parameter. If you uncheck this, the automatic text detection will be used to extract full content from the article. This checkbox is useful for some video CNN articles, which have different article structure from normal textual articles, and can have broken content imported from them.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Use Original Post Content For Posts That Don't Match Defined Importing HTML Class/ID:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="skip_no_class" name="newsomatic_Main_Settings[skip_no_class]"<?php
               if ($skip_no_class == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to full skip posts that don't match the html class or id you defined. This will work only if the previous checkbox is checked.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts That Don't Match Defined Importing HTML Class/ID:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_import_full" name="newsomatic_Main_Settings[no_import_full]"<?php
               if ($no_import_full == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to skip posts that don't get extracted correctly (full content).", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts That Are Not Extracted Correctly:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_import_no_class" name="newsomatic_Main_Settings[no_import_no_class]"<?php
               if ($no_import_no_class == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you the plugin to generate new categories if the category does not already exist.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Generate Inexistent Categories for New Posts:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="new_category" name="newsomatic_Main_Settings[new_category]"<?php
               if ($new_category == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to strip links from the generated post content.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Strip Links From Generated Post Content:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="strip_links" name="newsomatic_Main_Settings[strip_links]"<?php
               if ($strip_links == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to try to fix html tags that were incorrectly grabbed from source?", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Try To Fix Html Tags From Generated Posts Content:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="fix_html" name="newsomatic_Main_Settings[fix_html]"<?php
               if ($fix_html == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to strip JavaScript from the crawled post content.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Strip JavaScript From Crawled Content:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="strip_scripts" name="newsomatic_Main_Settings[strip_scripts]"<?php
               if ($strip_scripts == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Strip HTML elements from final content that have this IDs. You can insert more IDs, separeted by comma. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Strip HTML Elements from Final Content by ID:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="newsomatic_Main_Settings[strip_by_id]" placeholder="<?php echo esc_html__("Ids list", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($strip_by_id);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Strip HTML elements from final content that have this class. You can insert more classes, separeted by comma. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Strip HTML Elements from Final Content by Class:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="newsomatic_Main_Settings[strip_by_class]" placeholder="<?php echo esc_html__("Class list", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($strip_by_class);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the 'Read More' button text. This button is generated using the %%item_read_more_button%% shortcode. If you leave this field blank, the default value is 'Read More'.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("'Read More' Button Text:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="read_more" placeholder="<?php echo esc_html__("Read More", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[read_more]" value="<?php
                     echo esc_html($read_more);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Do you want to automatically translate generated content using? This settings is overwritten if you define translation settings from within the importing rule settings. If you wish to use DeepL for translation, you must enter first a DeepL 'Authentication Key'. Get one <a href='%s' target='_blank'>here</a>.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.deepl.com/subscription.html' ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Translate Content To (Global):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select class="cr_width_full" id="translate" name="newsomatic_Main_Settings[translate]" >
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                         echo '<option value="' . esc_html($language_codes[$i]) . '"';
                         if ($translate == $language_codes[$i]) {
                             echo ' selected';
                         }
                         echo '>' . esc_html($language_names[$i]) . '</option>';
                         $i++;
                     }
                     if($deepl_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_deepl as $lang) {
                             echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                             if ($translate == $language_codes_deepl[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                             $i++;
                         }
                     }
                     if($bing_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_bing as $lang) {
                             echo '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                             if ($translate == $language_codes_bing[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                             $i++;
                         }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to automatically translate generated content using Google Translate? Here you can define the translation's source language. This settings is overwritten if you define translation settings from within the importing rule settings.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Translation Source Language (Global):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select class="cr_width_full" id="translate_source" name="newsomatic_Main_Settings[translate_source]" >
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                         echo '<option value="' . esc_html($language_codes[$i]) . '"';
                         if ($translate_source == $language_codes[$i]) {
                             echo ' selected';
                         }
                         echo '>' . esc_html($language_names[$i]) . '</option>';
                         $i++;
                     }
                     if($deepl_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_deepl as $lang) {
                             echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                             if ($translate_source == $language_codes_deepl[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                             $i++;
                         }
                     }
                     if($bing_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_bing as $lang) {
                             echo '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                             if ($translate_source == $language_codes_bing[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                             $i++;
                         }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
          <tr>
             <td>
                <div>
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo esc_html__("Do you want to spin/translate only the imported article's title and content (not the whole post content - with additional content added to it from plugin settings)?", 'newsomatic-news-post-generator');
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("Spin/Translate Only Imported Article Title/Content:", 'newsomatic-news-post-generator');?></b>
             </td>
             <td>
             <input type="checkbox" id="litte_translate" name="newsomatic_Main_Settings[litte_translate]"<?php
                if ($litte_translate == 'on')
                    echo ' checked ';
                ?>>
             </div>
             </td>
          </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to import also posts that were not translated correctly - they will be imported in original language. If you check this, posts that failed translation will be not imported.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts That Did Not Translate Correctly:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="skip_failed_tr" name="newsomatic_Main_Settings[skip_failed_tr]"<?php
               if ($skip_failed_tr == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to keep original link sources after translation? If you uncheck this, links will point to Google Translate version of the linked website.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Keep Original Link Source After Translation:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_link_translate" name="newsomatic_Main_Settings[no_link_translate]"<?php
               if ($no_link_translate == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div id="bestspin">
                  <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'newsomatic-news-post-generator');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'newsomatic-news-post-generator');?></a></b></p>
               </div>
               <div id="wordai">
                  <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'newsomatic-news-post-generator');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'newsomatic-news-post-generator');?></a></b></p>
               </div>
               <div id="spinrewriter">
                  <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'newsomatic-news-post-generator');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'newsomatic-news-post-generator');?></a></b></p>
               </div>
               <div id="spinnerchief">
                  <p><?php echo esc_html__("Don't have an 'SpinnerChief' account yet? Click here to get one:", 'newsomatic-news-post-generator');?> <b><a href="http://www.whitehatbox.com/Agents/SSS?code=iscpuQScOZMi3vGFhPVBnAP5FyC6mPaOEshvgU4BbyoH8ftVRbM3uQ==" target="_blank"><?php echo esc_html__("get a new account now!", 'newsomatic-news-post-generator');?></a></b></p>
              </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Spin Text Using Word Synonyms (for automatically generated posts only):", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <select class="cr_width_full" id="spin_text" name="newsomatic_Main_Settings[spin_text]" onchange="mainChanged()">
            <option value="disabled"
               <?php
                  if ($spin_text == 'disabled') {
                      echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Disabled", 'newsomatic-news-post-generator');?></option>
            <option value="best"
               <?php
                  if ($spin_text == 'best') {
                      echo ' selected';
                  }
                  ?>
               >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'newsomatic-news-post-generator');?></option>
            <option value="wordai"
               <?php
                  if($spin_text == 'wordai')
                          {
                              echo ' selected';
                          }
                  ?>
               >Wordai - <?php echo esc_html__("High Quality - Paid", 'newsomatic-news-post-generator');?></option>
            <option value="spinrewriter"
               <?php
                  if($spin_text == 'spinrewriter')
                          {
                              echo ' selected';
                          }
                  ?>
               >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'newsomatic-news-post-generator');?></option>
               <option value="spinnerchief"
               <?php
                  if($spin_text == 'spinnerchief')
                          {
                              echo ' selected';
                          }
                  ?>
               >SpinnerChief - <?php echo esc_html__("High Quality - Paid", 'newsomatic-news-post-generator');?></option>
            <option value="builtin"
               <?php
                  if ($spin_text == 'builtin') {
                      echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Built-in - Medium Quality - Free", 'newsomatic-news-post-generator');?></option>
            </select>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to not spin title (only content)?", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Spin Title:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="checkbox" id="no_title_spin" name="newsomatic_Main_Settings[no_title_spin]"<?php
                     if ($no_title_spin == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select a list of comma separated words that you do not wish to spin (for built-in spinners and SpinRewriter).", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Excluded Word List (For Built-In Spinner and SpinRewriter):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="newsomatic_Main_Settings[exclude_words]" value="<?php
                     echo esc_html($exclude_words);
                     ?>" placeholder="<?php echo esc_html__("word1, word2, word3", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to automatically add the keywords found int he title to the spin exclusion list?", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Add Title Keywords To Excluded List:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="checkbox" id="exclude_words_title" name="newsomatic_Main_Settings[exclude_words_title]"<?php
                     if ($exclude_words_title == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr class="hideWord">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set WordAI spinning uniqueness. Depend on how conservative vs adventurous you want your rewrite to be.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("WordAI Spinning Uniqueness:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select class="cr_width_80" name="newsomatic_Main_Settings[wordai_uniqueness]" >
                     <option value='1'<?php
                        if ($wordai_uniqueness == '1')
                            echo ' selected';
                        ?>><?php echo esc_html__("More Conservative", 'newsomatic-news-post-generator');?></option>
                     <option value='2'<?php
                        if ($wordai_uniqueness == '2')
                            echo ' selected';
                        ?>><?php echo esc_html__("Regular", 'newsomatic-news-post-generator');?></option>
                     <option value='3'<?php
                        if ($wordai_uniqueness == '3')
                            echo ' selected';
                        ?>><?php echo esc_html__("More Adventurous", 'newsomatic-news-post-generator');?></option>
                  </select> 
               </div>
            </td>
         </tr>
         <tr class="hideChief">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the language of the content that will be processed.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("SpinnerChief Spinning Language:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                    <select class="cr_width_80" name="newsomatic_Main_Settings[spin_lang]" >
                     <option value='English'<?php
                        if ($spin_lang == 'English')
                            echo ' selected';
                        ?>><?php echo esc_html__("English", 'newsomatic-news-post-generator');?></option>
                     <option value='Arabic'<?php
                        if ($spin_lang == 'Arabic')
                            echo ' selected';
                        ?>><?php echo esc_html__("Arabic", 'newsomatic-news-post-generator');?></option>
                     <option value='Belarusian'<?php
                        if ($spin_lang == 'Belarusian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Belarusian", 'newsomatic-news-post-generator');?></option>
                     <option value='Bulgarian'<?php
                        if ($spin_lang == 'Bulgarian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Bulgarian", 'newsomatic-news-post-generator');?></option>
                     <option value='Croatian'<?php
                        if ($spin_lang == 'Croatian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Croatian", 'newsomatic-news-post-generator');?></option>
                     <option value='Danish'<?php
                        if ($spin_lang == 'Danish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Danish", 'newsomatic-news-post-generator');?></option>
                     <option value='Dutch'<?php
                        if ($spin_lang == 'Dutch')
                            echo ' selected';
                        ?>><?php echo esc_html__("Dutch", 'newsomatic-news-post-generator');?></option>
                     <option value='Filipino'<?php
                        if ($spin_lang == 'Filipino')
                            echo ' selected';
                        ?>><?php echo esc_html__("Filipino", 'newsomatic-news-post-generator');?></option>
                     <option value='Finnish'<?php
                        if ($spin_lang == 'Finnish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Finnish", 'newsomatic-news-post-generator');?></option>
                     <option value='French'<?php
                        if ($spin_lang == 'French')
                            echo ' selected';
                        ?>><?php echo esc_html__("French", 'newsomatic-news-post-generator');?></option>
                     <option value='German'<?php
                        if ($spin_lang == 'German')
                            echo ' selected';
                        ?>><?php echo esc_html__("German", 'newsomatic-news-post-generator');?></option>
                     <option value='Greek'<?php
                        if ($spin_lang == 'Greek')
                            echo ' selected';
                        ?>><?php echo esc_html__("Greek", 'newsomatic-news-post-generator');?></option>
                     <option value='Hebrew'<?php
                        if ($spin_lang == 'Hebrew')
                            echo ' selected';
                        ?>><?php echo esc_html__("Hebrew", 'newsomatic-news-post-generator');?></option>
                     <option value='Indonesian'<?php
                        if ($spin_lang == 'Indonesian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Indonesian", 'newsomatic-news-post-generator');?></option>
                     <option value='Italian'<?php
                        if ($spin_lang == 'Italian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Italian", 'newsomatic-news-post-generator');?></option>
                     <option value='Lithuanian'<?php
                        if ($spin_lang == 'Lithuanian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Lithuanian", 'newsomatic-news-post-generator');?></option>
                     <option value='Norwegian'<?php
                        if ($spin_lang == 'Norwegian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Norwegian", 'newsomatic-news-post-generator');?></option>
                     <option value='Polish'<?php
                        if ($spin_lang == 'Polish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Polish", 'newsomatic-news-post-generator');?></option>
                     <option value='Portuguese'<?php
                        if ($spin_lang == 'Portuguese')
                            echo ' selected';
                        ?>><?php echo esc_html__("Portuguese", 'newsomatic-news-post-generator');?></option>
                     <option value='Romanian'<?php
                        if ($spin_lang == 'Romanian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Romanian", 'newsomatic-news-post-generator');?></option>
                     <option value='Slovak'<?php
                        if ($spin_lang == 'Slovak')
                            echo ' selected';
                        ?>><?php echo esc_html__("Slovak", 'newsomatic-news-post-generator');?></option>
                     <option value='Slovenian'<?php
                        if ($spin_lang == 'Slovenian')
                            echo ' selected';
                        ?>><?php echo esc_html__("Slovenian", 'newsomatic-news-post-generator');?></option>
                     <option value='Spanish'<?php
                        if ($spin_lang == 'Spanish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Spanish", 'newsomatic-news-post-generator');?></option>
                     <option value='Swedish'<?php
                        if ($spin_lang == 'Swedish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Swedish", 'newsomatic-news-post-generator');?></option>
                     <option value='Turkish'<?php
                        if ($spin_lang == 'Turkish')
                            echo ' selected';
                        ?>><?php echo esc_html__("Turkish", 'newsomatic-news-post-generator');?></option>
                     <option value='Vietnamese'<?php
                        if ($spin_lang == 'Vietnamese')
                            echo ' selected';
                        ?>><?php echo esc_html__("Vietnamese", 'newsomatic-news-post-generator');?></option>
                  </select> 
                     
                     
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your user name on premium spinner service.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideBest">
                  <input type="text" name="newsomatic_Main_Settings[best_user]" value="<?php
                     echo esc_html($best_user);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service user name", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your password for the selected premium spinner service.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideBest">
                  <input type="password" autocomplete="off" name="newsomatic_Main_Settings[best_password]" value="<?php
                     echo esc_html($best_password);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service password", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Posting Restrictions:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the minimum word count for post titles. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Minimum Title Word Count (Skip Post Otherwise):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" class="cr_width_full" id="min_word_title" step="1" placeholder="<?php echo esc_html__("Input the minimum word count for the title", 'newsomatic-news-post-generator');?>" min="0" name="newsomatic_Main_Settings[min_word_title]" value="<?php
                     echo esc_html($min_word_title);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum word count for post titles. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Maximum Title Word Count (Skip Post Otherwise):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="max_word_title" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the title", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[max_word_title]" value="<?php
                     echo esc_html($max_word_title);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the minimum word count for post content. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Minimum Content Word Count (Skip Post Otherwise):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="min_word_content" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the minimum word count for the content", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[min_word_content]" value="<?php
                     echo esc_html($min_word_content);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum word count for post content. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Maximum Content Word Count (Skip Post Otherwise):", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="max_word_content" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the content", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[max_word_content]" value="<?php
                     echo esc_html($max_word_content);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do not include posts that's title or content contains at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Banned Words List:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="1" name="newsomatic_Main_Settings[banned_words]" placeholder="<?php echo esc_html__("Do not generate posts that contain at least one of these words", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($banned_words);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do not include posts that's title or content does not contain at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Required Words List:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="1" name="newsomatic_Main_Settings[required_words]" placeholder="<?php echo esc_html__("Do not generate posts unless they contain all of these words", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($required_words);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to all words defined in the required words list? If you uncheck this, if only one word is found, the article will be published.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Require All Words in the 'Required Words List':", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <input type="checkbox" id="require_all" name="newsomatic_Main_Settings[require_all]"<?php
                     if ($require_all == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to skip posts that do not have images.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts That Do Not Have Images:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="skip_no_img" name="newsomatic_Main_Settings[skip_no_img]"<?php
               if ($skip_no_img == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to skip posts that are older than a selected date.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts Older Than a Selected Date:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="skip_old" name="newsomatic_Main_Settings[skip_old]" onchange="mainChanged()"<?php
               if ($skip_old == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class='hideOld'>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the date prior which you want to skip posts.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Select the Date for Old Posts:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class='hideOld'>
                  <?php echo esc_html__("Day:", 'newsomatic-news-post-generator');?>
                  <select class="cr_width_80" name="newsomatic_Main_Settings[skip_day]" >
                     <option value='01'<?php
                        if ($skip_day == '01')
                            echo ' selected';
                        ?>>01</option>
                     <option value='02'<?php
                        if ($skip_day == '02')
                            echo ' selected';
                        ?>>02</option>
                     <option value='03'<?php
                        if ($skip_day == '03')
                            echo ' selected';
                        ?>>03</option>
                     <option value='04'<?php
                        if ($skip_day == '04')
                            echo ' selected';
                        ?>>04</option>
                     <option value='05'<?php
                        if ($skip_day == '05')
                            echo ' selected';
                        ?>>05</option>
                     <option value='06'<?php
                        if ($skip_day == '06')
                            echo ' selected';
                        ?>>06</option>
                     <option value='07'<?php
                        if ($skip_day == '07')
                            echo ' selected';
                        ?>>07</option>
                     <option value='08'<?php
                        if ($skip_day == '08')
                            echo ' selected';
                        ?>>08</option>
                     <option value='09'<?php
                        if ($skip_day == '09')
                            echo ' selected';
                        ?>>09</option>
                     <option value='10'<?php
                        if ($skip_day == '10')
                            echo ' selected';
                        ?>>10</option>
                     <option value='11'<?php
                        if ($skip_day == '11')
                            echo ' selected';
                        ?>>11</option>
                     <option value='12'<?php
                        if ($skip_day == '12')
                            echo ' selected';
                        ?>>12</option>
                     <option value='13'<?php
                        if ($skip_day == '13')
                            echo ' selected';
                        ?>>13</option>
                     <option value='14'<?php
                        if ($skip_day == '14')
                            echo ' selected';
                        ?>>14</option>
                     <option value='15'<?php
                        if ($skip_day == '15')
                            echo ' selected';
                        ?>>15</option>
                     <option value='16'<?php
                        if ($skip_day == '16')
                            echo ' selected';
                        ?>>16</option>
                     <option value='17'<?php
                        if ($skip_day == '17')
                            echo ' selected';
                        ?>>17</option>
                     <option value='18'<?php
                        if ($skip_day == '18')
                            echo ' selected';
                        ?>>18</option>
                     <option value='19'<?php
                        if ($skip_day == '19')
                            echo ' selected';
                        ?>>19</option>
                     <option value='20'<?php
                        if ($skip_day == '20')
                            echo ' selected';
                        ?>>20</option>
                     <option value='21'<?php
                        if ($skip_day == '21')
                            echo ' selected';
                        ?>>21</option>
                     <option value='22'<?php
                        if ($skip_day == '22')
                            echo ' selected';
                        ?>>22</option>
                     <option value='23'<?php
                        if ($skip_day == '23')
                            echo ' selected';
                        ?>>23</option>
                     <option value='24'<?php
                        if ($skip_day == '24')
                            echo ' selected';
                        ?>>24</option>
                     <option value='25'<?php
                        if ($skip_day == '25')
                            echo ' selected';
                        ?>>25</option>
                     <option value='26'<?php
                        if ($skip_day == '26')
                            echo ' selected';
                        ?>>26</option>
                     <option value='27'<?php
                        if ($skip_day == '27')
                            echo ' selected';
                        ?>>27</option>
                     <option value='28'<?php
                        if ($skip_day == '28')
                            echo ' selected';
                        ?>>28</option>
                     <option value='29'<?php
                        if ($skip_day == '29')
                            echo ' selected';
                        ?>>29</option>
                     <option value='30'<?php
                        if ($skip_day == '30')
                            echo ' selected';
                        ?>>30</option>
                     <option value='31'<?php
                        if ($skip_day == '31')
                            echo ' selected';
                        ?>>31</option>
                  </select>
                  <?php echo esc_html__("Month:", 'newsomatic-news-post-generator');?>
                  <select class="cr_width_80" name="newsomatic_Main_Settings[skip_month]" >
                     <option value='01'<?php
                        if ($skip_month == '01')
                            echo ' selected';
                        ?>><?php echo esc_html__("January", 'newsomatic-news-post-generator');?></option>
                     <option value='02'<?php
                        if ($skip_month == '02')
                            echo ' selected';
                        ?>><?php echo esc_html__("February", 'newsomatic-news-post-generator');?></option>
                     <option value='03'<?php
                        if ($skip_month == '03')
                            echo ' selected';
                        ?>><?php echo esc_html__("March", 'newsomatic-news-post-generator');?></option>
                     <option value='04'<?php
                        if ($skip_month == '04')
                            echo ' selected';
                        ?>><?php echo esc_html__("April", 'newsomatic-news-post-generator');?></option>
                     <option value='05'<?php
                        if ($skip_month == '05')
                            echo ' selected';
                        ?>><?php echo esc_html__("May", 'newsomatic-news-post-generator');?></option>
                     <option value='06'<?php
                        if ($skip_month == '06')
                            echo ' selected';
                        ?>><?php echo esc_html__("June", 'newsomatic-news-post-generator');?></option>
                     <option value='07'<?php
                        if ($skip_month == '07')
                            echo ' selected';
                        ?>><?php echo esc_html__("July", 'newsomatic-news-post-generator');?></option>
                     <option value='08'<?php
                        if ($skip_month == '08')
                            echo ' selected';
                        ?>><?php echo esc_html__("August", 'newsomatic-news-post-generator');?></option>
                     <option value='09'<?php
                        if ($skip_month == '09')
                            echo ' selected';
                        ?>><?php echo esc_html__("September", 'newsomatic-news-post-generator');?></option>
                     <option value='10'<?php
                        if ($skip_month == '10')
                            echo ' selected';
                        ?>><?php echo esc_html__("October", 'newsomatic-news-post-generator');?></option>
                     <option value='11'<?php
                        if ($skip_month == '11')
                            echo ' selected';
                        ?>><?php echo esc_html__("November", 'newsomatic-news-post-generator');?></option>
                     <option value='12'<?php
                        if ($skip_month == '12')
                            echo ' selected';
                        ?>><?php echo esc_html__("December", 'newsomatic-news-post-generator');?></option>
                  </select>
                  <?php echo esc_html__("Year:", 'newsomatic-news-post-generator');?><input class="cr_width_70" value="<?php
                     echo esc_html($skip_year);
                     ?>" placeholder="<?php echo esc_html__("year", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[skip_year]" type="text" pattern="^\d{4}$">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Featured Image Options:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Click this option if your want to set the featured image from the remote image location. This settings can save disk space, but beware that if the remote image gets deleted, your featured image will also be broken.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Copy Featured Image Locally:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_local_image" name="newsomatic_Main_Settings[no_local_image]"<?php
               if ($no_local_image == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
              <tr>
                 <td>
                    <div>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Click this option to enable integration with the 'Featured Image from URL' plugin - https://wordpress.org/plugins/featured-image-from-url/. To enable this option, you need to deactivate the 'Do Not Copy Featured Image Locally' checkbox from above.", 'newsomatic-news-post-generator');
                                ?>
                          </div>
                       </div>
                       <b><?php echo esc_html__("Enable 'Featured Image from URL' Integration:", 'newsomatic-news-post-generator');?></b>
                 </td>
                 <td>
                 <input type="checkbox" id="url_image" name="newsomatic_Main_Settings[url_image]"<?php
                    if ($url_image == 'on')
                        echo ' checked ';
                    ?>>
                 </div>
                 </td>
              </tr>
         <tr>
             <td>
                <div>
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo esc_html__("Choose if you want to strip featured image from the generated post content.", 'newsomatic-news-post-generator');
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("Strip Featured Image From Generated Post Content:", 'newsomatic-news-post-generator');?></b>
             </td>
             <td>
             <input type="checkbox" id="strip_featured_image" name="newsomatic_Main_Settings[strip_featured_image]"<?php
                if ($strip_featured_image == 'on')
                    echo ' checked ';
                ?>>
             </div>
             </td>
          </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Featured Image Resize Width:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" min="1" step="1" class="cr_width_full" name="newsomatic_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for featured images", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Featured Image Resize Height:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" min="1" step="1" class="cr_width_full" name="newsomatic_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for featured images", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option if your want to save images found in post content locally. Note that this option may be heavy on your hosting free space.", 'newsomatic-news-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Copy Images From Content Locally:", 'newsomatic-news-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="copy_images" name="newsomatic_Main_Settings[copy_images]"<?php
                        if ($copy_images == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Royalty Free Featured Image Importing Options:", 'newsomatic-news-post-generator');?></h3>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your MorgueFile App ID. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("MorgueFile App ID:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="newsomatic_Main_Settings[morguefile_api]" value="<?php
                     echo esc_html($morguefile_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API key", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your MorgueFile App Secret. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("MorgueFile App Secret:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="newsomatic_Main_Settings[morguefile_secret]" value="<?php
                     echo esc_html($morguefile_secret);
                     ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API Secret", 'newsomatic-news-post-generator');?>">
               </div>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         </td></tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Pexels App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Pexels API.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.pexels.com/api/" ));
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Pexels App ID:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="newsomatic_Main_Settings[pexels_api]" value="<?php
                     echo esc_html($pexels_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your Pexels API key", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo sprintf( wp_kses( __( "Insert your Flickr App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Flickr API.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.flickr.com/services/apps/create/apply" ));
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Flickr App ID: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="text" name="newsomatic_Main_Settings[flickr_api]" placeholder="<?php echo esc_html__("Please insert your Flickr APP ID", 'newsomatic-news-post-generator');?>" value="<?php if(isset($flickr_api)){echo esc_html($flickr_api);}?>" class="cr_width_full" />
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("The license id for photos to be searched.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Photo License: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[flickr_license]" class="cr_width_full">
                  <option value="-1" 
                     <?php
                        if($flickr_license == '-1')
                        {
                            echo ' selected';
                        }
                        ?>
                     ><?php echo esc_html__("Do Not Search By Photo Licenses", 'newsomatic-news-post-generator');?></option>
                  <option value="0"
                     <?php
                        if($flickr_license == '0')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("All Rights Reserved", 'newsomatic-news-post-generator');?></option>
                  <option value="1"
                     <?php
                        if($flickr_license == '1')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial-ShareAlike License", 'newsomatic-news-post-generator');?></option>
                  <option value="2"
                     <?php
                        if($flickr_license == '2')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial License", 'newsomatic-news-post-generator');?></option>
                  <option value="3"
                     <?php
                        if($flickr_license == '3')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial-NoDerivs License", 'newsomatic-news-post-generator');?></option>
                  <option value="4"
                     <?php
                        if($flickr_license == '4')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution License", 'newsomatic-news-post-generator');?></option>
                  <option value="5"
                     <?php
                        if($flickr_license == '5')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-ShareAlike License", 'newsomatic-news-post-generator');?></option>
                  <option value="6"
                     <?php
                        if($flickr_license == '6')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NoDerivs License", 'newsomatic-news-post-generator');?></option>
                  <option value="7"
                     <?php
                        if($flickr_license == '7')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("No known copyright restrictions", 'newsomatic-news-post-generator');?></option>
                  <option value="8"
                     <?php
                        if($flickr_license == '8')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("United States Government Work", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("The order in which to sort returned photos. Deafults to date-posted-desc (unless you are doing a radial geo query, in which case the default sorting is by ascending distance from the point specified).", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Search Results Order: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[flickr_order]" class="cr_width_full">
                  <option value="date-posted-desc"
                     <?php
                        if($flickr_order == 'date-posted-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Posted Descendant", 'newsomatic-news-post-generator');?></option>
                  <option value="date-posted-asc"
                     <?php
                        if($flickr_order == 'date-posted-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Posted Ascendent", 'newsomatic-news-post-generator');?></option>
                  <option value="date-taken-asc"
                     <?php
                        if($flickr_order == 'date-taken-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Taken Ascendent", 'newsomatic-news-post-generator');?></option>
                  <option value="date-taken-desc"
                     <?php
                        if($flickr_order == 'date-taken-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Taken Descendant", 'newsomatic-news-post-generator');?></option>
                  <option value="interestingness-desc"
                     <?php
                        if($flickr_order == 'interestingness-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Interestingness Descendant", 'newsomatic-news-post-generator');?></option>
                  <option value="interestingness-asc"
                     <?php
                        if($flickr_order == 'interestingness-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Interestingness Ascendant", 'newsomatic-news-post-generator');?></option>
                  <option value="relevance"
                     <?php
                        if($flickr_order == 'relevance')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Relevance", 'newsomatic-news-post-generator');?></option>
               </select>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         </td></tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Pixabay App ID. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter an API Key here, you will enable search for images using the Pixabay API.", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://pixabay.com/api/docs/" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Pixabay App ID:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="newsomatic_Main_Settings[pixabay_api]" value="<?php
                     echo esc_html($pixabay_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your Pixabay API key", 'newsomatic-news-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Filter results by image type.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Image Types To Search:", 'newsomatic-news-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select class="cr_width_full" name="newsomatic_Main_Settings[imgtype]" >
                     <option value='all'<?php
                        if ($imgtype == 'all')
                            echo ' selected';
                        ?>><?php echo esc_html__("All", 'newsomatic-news-post-generator');?></option>
                     <option value='photo'<?php
                        if ($imgtype == 'photo')
                            echo ' selected';
                        ?>><?php echo esc_html__("Photo", 'newsomatic-news-post-generator');?></option>
                     <option value='illustration'<?php
                        if ($imgtype == 'illustration')
                            echo ' selected';
                        ?>><?php echo esc_html__("Illustration", 'newsomatic-news-post-generator');?></option>
                     <option value='vector'<?php
                        if ($imgtype == 'vector')
                            echo ' selected';
                        ?>><?php echo esc_html__("Vector", 'newsomatic-news-post-generator');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Order results by a predefined rule.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Results Order: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[img_order]" class="cr_width_full">
                  <option value="popular"<?php
                     if ($img_order == "popular") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Popular", 'newsomatic-news-post-generator');?></option>
                  <option value="latest"<?php
                     if ($img_order == "latest") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Latest", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image category.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Category: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[img_cat]" class="cr_width_full">
                  <option value="all"<?php
                     if ($img_cat == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'newsomatic-news-post-generator');?></option>
                  <option value="fashion"<?php
                     if ($img_cat == "fashion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Fashion", 'newsomatic-news-post-generator');?></option>
                  <option value="nature"<?php
                     if ($img_cat == "nature") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Nature", 'newsomatic-news-post-generator');?></option>
                  <option value="backgrounds"<?php
                     if ($img_cat == "backgrounds") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Backgrounds", 'newsomatic-news-post-generator');?></option>
                  <option value="science"<?php
                     if ($img_cat == "science") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Science", 'newsomatic-news-post-generator');?></option>
                  <option value="education"<?php
                     if ($img_cat == "education") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Education", 'newsomatic-news-post-generator');?></option>
                  <option value="people"<?php
                     if ($img_cat == "people") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("People", 'newsomatic-news-post-generator');?></option>
                  <option value="feelings"<?php
                     if ($img_cat == "feelings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Feelings", 'newsomatic-news-post-generator');?></option>
                  <option value="religion"<?php
                     if ($img_cat == "religion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Religion", 'newsomatic-news-post-generator');?></option>
                  <option value="health"<?php
                     if ($img_cat == "health") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Health", 'newsomatic-news-post-generator');?></option>
                  <option value="places"<?php
                     if ($img_cat == "places") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Places", 'newsomatic-news-post-generator');?></option>
                  <option value="animals"<?php
                     if ($img_cat == "animals") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Animals", 'newsomatic-news-post-generator');?></option>
                  <option value="industry"<?php
                     if ($img_cat == "industry") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Industry", 'newsomatic-news-post-generator');?></option>
                  <option value="food"<?php
                     if ($img_cat == "food") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Food", 'newsomatic-news-post-generator');?></option>
                  <option value="computer"<?php
                     if ($img_cat == "computer") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Computer", 'newsomatic-news-post-generator');?></option>
                  <option value="sports"<?php
                     if ($img_cat == "sports") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Sports", 'newsomatic-news-post-generator');?></option>
                  <option value="transportation"<?php
                     if ($img_cat == "transportation") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Transportation", 'newsomatic-news-post-generator');?></option>
                  <option value="travel"<?php
                     if ($img_cat == "travel") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Travel", 'newsomatic-news-post-generator');?></option>
                  <option value="buildings"<?php
                     if ($img_cat == "buildings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Buildings", 'newsomatic-news-post-generator');?></option>
                  <option value="business"<?php
                     if ($img_cat == "business") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Business", 'newsomatic-news-post-generator');?></option>
                  <option value="music"<?php
                     if ($img_cat == "music") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Music", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Minimum image width.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Width: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="newsomatic_Main_Settings[img_width]" value="<?php echo esc_html($img_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'newsomatic-news-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Maximum image width.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Max Width: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="newsomatic_Main_Settings[img_mwidth]" value="<?php echo esc_html($img_mwidth);?>" placeholder="<?php echo esc_html__("Please insert image max width", 'newsomatic-news-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("A flag indicating that only images suitable for all ages should be returned.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Safe Search: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[img_ss]"<?php
                  if ($img_ss == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Select images that have received an Editor's Choice award.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Editor\'s Choice: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[img_editor]"<?php
                  if ($img_editor == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Specify default language for regional content.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Filter Language: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[img_language]" class="cr_width_full">
                  <option value="any"<?php
                     if ($img_language == "any") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Any", 'newsomatic-news-post-generator');?></option>
                  <option value="en"<?php
                     if ($img_language == "en") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("English", 'newsomatic-news-post-generator');?></option>
                  <option value="cs"<?php
                     if ($img_language == "cs") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Czech", 'newsomatic-news-post-generator');?></option>
                  <option value="da"<?php
                     if ($img_language == "da") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Danish", 'newsomatic-news-post-generator');?></option>
                  <option value="de"<?php
                     if ($img_language == "de") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("German", 'newsomatic-news-post-generator');?></option>
                  <option value="es"<?php
                     if ($img_language == "es") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Spanish", 'newsomatic-news-post-generator');?></option>
                  <option value="fr"<?php
                     if ($img_language == "fr") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("French", 'newsomatic-news-post-generator');?></option>
                  <option value="id"<?php
                     if ($img_language == "id") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Indonesian", 'newsomatic-news-post-generator');?></option>
                  <option value="it"<?php
                     if ($img_language == "it") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Italian", 'newsomatic-news-post-generator');?></option>
                  <option value="hu"<?php
                     if ($img_language == "hu") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Hungarian", 'newsomatic-news-post-generator');?></option>
                  <option value="nl"<?php
                     if ($img_language == "nl") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Dutch", 'newsomatic-news-post-generator');?></option>
                  <option value="no"<?php
                     if ($img_language == "no") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Norvegian", 'newsomatic-news-post-generator');?></option>
                  <option value="pl"<?php
                     if ($img_language == "pl") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Polish", 'newsomatic-news-post-generator');?></option>
                  <option value="pt"<?php
                     if ($img_language == "pt") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Portuguese", 'newsomatic-news-post-generator');?></option>
                  <option value="ro"<?php
                     if ($img_language == "ro") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Romanian", 'newsomatic-news-post-generator');?></option>
                  <option value="sk"<?php
                     if ($img_language == "sk") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Slovak", 'newsomatic-news-post-generator');?></option>
                  <option value="fi"<?php
                     if ($img_language == "fi") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Finish", 'newsomatic-news-post-generator');?></option>
                  <option value="sv"<?php
                     if ($img_language == "sv") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Swedish", 'newsomatic-news-post-generator');?></option>
                  <option value="tr"<?php
                     if ($img_language == "tr") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Turkish", 'newsomatic-news-post-generator');?></option>
                  <option value="vi"<?php
                     if ($img_language == "vi") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vietnamese", 'newsomatic-news-post-generator');?></option>
                  <option value="th"<?php
                     if ($img_language == "th") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Thai", 'newsomatic-news-post-generator');?></option>
                  <option value="bg"<?php
                     if ($img_language == "bg") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Bulgarian", 'newsomatic-news-post-generator');?></option>
                  <option value="ru"<?php
                     if ($img_language == "ru") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Russian", 'newsomatic-news-post-generator');?></option>
                  <option value="el"<?php
                     if ($img_language == "el") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Greek", 'newsomatic-news-post-generator');?></option>
                  <option value="ja"<?php
                     if ($img_language == "ja") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Japanese", 'newsomatic-news-post-generator');?></option>
                  <option value="ko"<?php
                     if ($img_language == "ko") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Korean", 'newsomatic-news-post-generator');?></option>
                  <option value="zh"<?php
                     if ($img_language == "zh") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Chinese", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Select if you want to enable usage of the Unsplash API for getting images.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Enable Unsplash API Usage: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[unsplash_api]"<?php
                  if ($unsplash_api == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Select if you want to enable direct scraping of Pixabay website. This will generate different results from the API.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Enable Pixabay Direct Website Scraping: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[pixabay_scrape]"<?php
                  if ($pixabay_scrape == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image type.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Types To Search: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[scrapeimgtype]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimgtype == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'newsomatic-news-post-generator');?></option>
                  <option value="photo"<?php
                     if ($scrapeimgtype == "photo") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Photo", 'newsomatic-news-post-generator');?></option>
                  <option value="illustration"<?php
                     if ($scrapeimgtype == "illustration") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Illustration", 'newsomatic-news-post-generator');?></option>
                  <option value="vector"<?php
                     if ($scrapeimgtype == "vector") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vector", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image orientation.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Orientation: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[scrapeimg_orientation]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimg_orientation == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'newsomatic-news-post-generator');?></option>
                  <option value="horizontal"<?php
                     if ($scrapeimg_orientation == "horizontal") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Horizontal", 'newsomatic-news-post-generator');?></option>
                  <option value="vertical"<?php
                     if ($scrapeimg_orientation == "vertical") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vertical", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Order results by a predefined rule.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Results Order: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[scrapeimg_order]" class="cr_width_full">
                  <option value="any"<?php
                     if ($scrapeimg_order == "any") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Any", 'newsomatic-news-post-generator');?></option>
                  <option value="popular"<?php
                     if ($scrapeimg_order == "popular") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Popular", 'newsomatic-news-post-generator');?></option>
                  <option value="latest"<?php
                     if ($scrapeimg_order == "latest") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Latest", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image category.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Category: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <select name="newsomatic_Main_Settings[scrapeimg_cat]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimg_cat == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'newsomatic-news-post-generator');?></option>
                  <option value="fashion"<?php
                     if ($scrapeimg_cat == "fashion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Fashion", 'newsomatic-news-post-generator');?></option>
                  <option value="nature"<?php
                     if ($scrapeimg_cat == "nature") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Nature", 'newsomatic-news-post-generator');?></option>
                  <option value="backgrounds"<?php
                     if ($scrapeimg_cat == "backgrounds") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Backgrounds", 'newsomatic-news-post-generator');?></option>
                  <option value="science"<?php
                     if ($scrapeimg_cat == "science") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Science", 'newsomatic-news-post-generator');?></option>
                  <option value="education"<?php
                     if ($scrapeimg_cat == "education") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Education", 'newsomatic-news-post-generator');?></option>
                  <option value="people"<?php
                     if ($scrapeimg_cat == "people") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("People", 'newsomatic-news-post-generator');?></option>
                  <option value="feelings"<?php
                     if ($scrapeimg_cat == "feelings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Feelings", 'newsomatic-news-post-generator');?></option>
                  <option value="religion"<?php
                     if ($scrapeimg_cat == "religion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Religion", 'newsomatic-news-post-generator');?></option>
                  <option value="health"<?php
                     if ($scrapeimg_cat == "health") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Health", 'newsomatic-news-post-generator');?></option>
                  <option value="places"<?php
                     if ($scrapeimg_cat == "places") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Places", 'newsomatic-news-post-generator');?></option>
                  <option value="animals"<?php
                     if ($scrapeimg_cat == "animals") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Animals", 'newsomatic-news-post-generator');?></option>
                  <option value="industry"<?php
                     if ($scrapeimg_cat == "industry") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Industry", 'newsomatic-news-post-generator');?></option>
                  <option value="food"<?php
                     if ($scrapeimg_cat == "food") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Food", 'newsomatic-news-post-generator');?></option>
                  <option value="computer"<?php
                     if ($scrapeimg_cat == "computer") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Computer", 'newsomatic-news-post-generator');?></option>
                  <option value="sports"<?php
                     if ($scrapeimg_cat == "sports") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Sports", 'newsomatic-news-post-generator');?></option>
                  <option value="transportation"<?php
                     if ($scrapeimg_cat == "transportation") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Transportation", 'newsomatic-news-post-generator');?></option>
                  <option value="travel"<?php
                     if ($scrapeimg_cat == "travel") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Travel", 'newsomatic-news-post-generator');?></option>
                  <option value="buildings"<?php
                     if ($scrapeimg_cat == "buildings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Buildings", 'newsomatic-news-post-generator');?></option>
                  <option value="business"<?php
                     if ($scrapeimg_cat == "business") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Business", 'newsomatic-news-post-generator');?></option>
                  <option value="music"<?php
                     if ($scrapeimg_cat == "music") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Music", 'newsomatic-news-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Minimum image width.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Width: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="newsomatic_Main_Settings[scrapeimg_width]" value="<?php echo esc_html($scrapeimg_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'newsomatic-news-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Maximum image height.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Height: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="newsomatic_Main_Settings[scrapeimg_height]" value="<?php echo esc_html($scrapeimg_height);?>" placeholder="<?php echo esc_html__("Please insert image min height", 'newsomatic-news-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Please set a the image attribution shortcode value. You can use this value, using the %%image_attribution%% shortcode, in 'Prepend Content With' and 'Append Content With' settings fields. You can use the following shortcodes, in this settings field: %%image_source_name%%, %%image_source_website%%, %%image_source_url%%. These will be updated automatically for the respective image source, from where the imported image is from. This will replace the %%royalty_free_image_attribution%% shortcode, in 'Generated Post Content' settings field.", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Royalty Free Image Attribution Text (%%royalty_free_image_attribution%%): ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="text" name="newsomatic_Main_Settings[attr_text]" value="<?php echo esc_html(stripslashes($attr_text));?>" placeholder="<?php echo esc_html__("Please insert image attribution text pattern", 'newsomatic-news-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Do you want to enable broad search for royalty free images?", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Enable broad image search: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[bimage]" <?php
                  if ($bimage == 'on') {
                      echo 'checked="checked"';
                  }
                  ?> />
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Do you want to not use article's original image if no royalty free image found for the post?", 'newsomatic-news-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Do Not Use Original Image If No Free Image Found: ', 'newsomatic-news-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="newsomatic_Main_Settings[no_orig]" <?php
                  if ($no_orig == 'on') {
                      echo 'checked="checked"';
                  }
                  ?> />
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
          <tr>
             <td colspan="2">
                <h3><?php echo esc_html__("PhantomJS Settings:", 'newsomatic-news-post-generator');?></h3>
             </td>
          </tr>
          <tr>
             <td>
                <div>
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo sprintf( wp_kses( __( "Set the path on your local server of the phantomjs executable. If you leave this field blank, the default 'phantomjs' call will be used. <a href='%s' target='_blank'>How to install PhantomJs?</a>", 'newsomatic-news-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/" ));
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("PhantomJS Path On Server:", 'newsomatic-news-post-generator');?></b>
<?php
               if($phantom_path != '')
               {
                   $phantom = newsomatic_testPhantom();
                   if($phantom === 0)
                   {
                       echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS not found - please install it on your server or configure the path to it in plugin\'s \'Main Settings\'!', 'newsomatic-news-post-generator') . '</b> <a href=\'//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/\' target=\'_blank\'>' . esc_html__('How to install PhantomJs?', 'newsomatic-news-post-generator') . '</a></span>';
                   }
                   elseif($phantom === -1)
                   {
                       echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not enabled on your server. Please enable it and retry using this feature of the plugin.', 'newsomatic-news-post-generator') . '</b></span>';
                   }
                   elseif($phantom === -2)
                   {
                       echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not allowed to run on your server (in disable_functions list in php.ini). Please enable it and retry using this feature of the plugin.', 'newsomatic-news-post-generator') . '</b></span>';
                   }
                   elseif($phantom === 1)
                   {
                       echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS OK', 'newsomatic-news-post-generator') . '</b></span>';
                   }
               }
?>
                </div>
             </td>
             <td>
                <div>
                   <input type="text" id="phantom_path" placeholder="<?php echo esc_html__("Path to phantomjs", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[phantom_path]" value="<?php echo esc_html($phantom_path);?>"/>
                </div>
             </td>
          </tr>
          <tr>
             <td>
                <div>
                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                      <div class="bws_hidden_help_text cr_min_260px">
                         <?php
                            echo esc_html__("Set the timeout (in milliseconds) for every phantomjs running. I recommend that you leave this field at it's default value (15000). If you leave this field blank, the default value will be used.", 'newsomatic-news-post-generator');
                            ?>
                      </div>
                   </div>
                   <b><?php echo esc_html__("Timeout for PhantomJs Execution:", 'newsomatic-news-post-generator');?></b>
                </div>
             </td>
             <td>
                <div>
                   <input type="number" id="phantom_timeout" step="1" min="1" placeholder="<?php echo esc_html__("Input phantomjs timeout in milliseconds", 'newsomatic-news-post-generator');?>" name="newsomatic_Main_Settings[phantom_timeout]" value="<?php echo esc_html($phantom_timeout);?>"/>
                </div>
             </td>
          </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Random Sentence Generator Settings:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="newsomatic_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($sentence_list);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="newsomatic_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($sentence_list2);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
                           Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("List of Possible Variables:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="newsomatic_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($variable_list);
               ?></textarea>
            </div></td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Custom HTML Code/ Ad Code:", 'newsomatic-news-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Custom HTML Code #1:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="newsomatic_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($custom_html);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'newsomatic-news-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Custom HTML Code #2:", 'newsomatic-news-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="newsomatic_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'newsomatic-news-post-generator');?>"><?php
               echo esc_textarea($custom_html2);
               ?></textarea>
            </div>
            </td>
         </tr>
      </table>
      <hr/>
      <h3><?php echo esc_html__("Affiliate Keyword Replacer Tool Settings:", 'newsomatic-news-post-generator');?></h3>
      <div class="table-responsive">
         <table class="responsive table cr_main_table">
            <thead>
               <tr>
                  <th>
                     <?php echo esc_html__("ID", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This is the ID of the rule.", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_max_width_40">
                     <?php echo esc_html__("Del", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to delete this rule?", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Search Keyword", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This keyword will be replaced with a link you define.", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Replacement Keyword", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Link to Add", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Target Content", 'newsomatic-news-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to make this rule target post title, content or both.", 'newsomatic-news-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
               </tr>
               <tr>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
               </tr>
            </thead>
            <tbody>
               <?php
                  echo newsomatic_expand_keyword_rules();
                  ?>
               <tr>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
               </tr>
               <tr>
                  <td class="cr_short_td">-</td>
                  <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                  <td class="cr_rule_line"><input type="text" name="newsomatic_keyword_list[keyword][]"  placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'newsomatic-news-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_rule_line"><input type="text" name="newsomatic_keyword_list[replace][]"  placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'newsomatic-news-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_rule_line"><input type="url" validator="url" name="newsomatic_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'newsomatic-news-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_xoq">
                     <select id="newsomatic_keyword_target" name="newsomatic_keyword_list[target][]" class="cr_width_full">
                        <option value="content" selected><?php echo esc_html__("Content", 'newsomatic-news-post-generator');?></option>
                        <option value="title"><?php echo esc_html__("Title", 'newsomatic-news-post-generator');?></option>
                        <option value="both"><?php echo esc_html__("Content and Title", 'newsomatic-news-post-generator');?></option>
                     </select>
                  </td>
               </tr>
            </tbody>
         </table>
         <hr/>
         <p>
            <?php echo esc_html__("Available shortcodes (the plugin also provides Gutenberg blocks for these shortcodes):", 'newsomatic-news-post-generator');?> <strong>[newsomatic-news-aggregator]</strong> <?php echo esc_html__("to display an automatically updating aggregated news list in your pages, using different stylings", 'rss-feed-post-generator-echo');?>,  <strong>[newsomatic-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin, and", 'newsomatic-news-post-generator');?> <strong>[newsomatic-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'newsomatic-news-post-generator');?> [newsomatic-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" link_to_source='yes' order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_newsomatic_rule' ruletype='0/1'].
            <br/><?php echo esc_html__("Example:", 'rss-feed-post-generator-echo');?> <b>[newsomatic-news-aggregator layout="ticker" ticker_type="marquee" max_news_number="9" sources="CNET" ticker_text_color="red" ticker_label_color="white" ticker_color="red" caching_time="360"]</b>
            <br/><?php echo esc_html__("Example 2:", 'newsomatic-news-post-generator');?> <b>[newsomatic-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0' ruletype='0']</b>
            <br/><?php echo esc_html__("Example 3:", 'newsomatic-news-post-generator');?> <b>[newsomatic-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div' ruleid='0' ruletype='0']</b>.
         </p>
         <div>
            <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'newsomatic-news-post-generator');?>"/></p>
         </div>
</form>
</div>
</div>
<?php
   }
   if (isset($_POST['newsomatic_keyword_list'])) {
       add_action('admin_init', 'newsomatic_save_keyword_rules');
   }
   function newsomatic_save_keyword_rules($data2)
   {
       $data2 = $_POST['newsomatic_keyword_list'];
       $rules = array();
       if (isset($data2['keyword'][0])) {
           for ($i = 0; $i < sizeof($data2['keyword']); ++$i) {
               if (isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '') {
                   $index         = trim(sanitize_text_field($data2['keyword'][$i]));
                   $rules[$index] = array(
                       trim(sanitize_text_field($data2['link'][$i])),
                       trim(sanitize_text_field($data2['replace'][$i])),
                       trim(sanitize_text_field($data2['target'][$i]))
                   );
               }
           }
       }
       update_option('newsomatic_keyword_list', $rules);
   }
   function newsomatic_expand_keyword_rules()
   {
       $rules  = get_option('newsomatic_keyword_list');
    if(!is_array($rules))
    {
       $rules = array();
    }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) {
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_shrt_td2"><span class="wpnewsomatic-delete">X</span></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'newsomatic-news-post-generator') . '" name="newsomatic_keyword_list[keyword][]" value="' . esc_html($request) . '" required class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'newsomatic-news-post-generator') . '" name="newsomatic_keyword_list[replace][]" value="' . esc_html($value[1]) . '" class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'newsomatic-news-post-generator') . '" name="newsomatic_keyword_list[link][]" value="' . esc_html($value[0]) . '" class="cr_width_100"></td>';
                           if(isset($value[2]))
                           {
                               $target = $value[2];
                           }
                           else
                           {
                               $target = 'content';
                           }
                           $output .= '<td class="cr_xoq"><select id="newsomatic_keyword_target" name="newsomatic_keyword_list[target][]" class="cr_width_full">
                                     <option value="content"';
                           if ($target == "content") {
                               $output .= " selected";
                           }
                           $output .= '>' . esc_html__('Content', 'newsomatic-news-post-generator') . '</option>
                           <option value="title"';
                           if ($target == "title") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Title', 'newsomatic-news-post-generator') . '</option>
                           <option value="both"';
                           if ($target == "both") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Content and Title', 'newsomatic-news-post-generator') . '</option>
                       </select></td>
   					</tr>';
               $cont++;
           }
       }
       return $output;
   }
   ?>