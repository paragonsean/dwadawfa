<?php
namespace NewsParserPlugin\Traits;

/**
 * Methods to sanitize input data.
 *
 * PHP version 5.6
 *
 * @package  Parser
 * @author   Evgeniy S.Zalevskiy <2600@urk.net>
 * @license  MIT
 */
trait SanitizeDataTrait
{
    /**
     * Sanitize MediaOptions data.
     *
     * @param array $options ['postId','alt']
     * @return array
     */
    public function sanitizeMediaOptions($options)
    {
        $new_array=array();
        $new_array['post_id']=preg_replace('/[^0-9]/', '', $options['post_id']);
        $new_array['alt']=esc_attr($options['alt']);
        return $new_array;
    }
    /**
     * Sanitize extra options part of input options.
     *
     * @param array $extra_options ['addFeaturedMedia','saveParsingTemplate','addSource']
     * @return array
     */
    public function sanitizeExtraOptions($extra_options)
    {
        $clean_data=array();
        foreach ($extra_options as $key => $option) {
            switch ($key) {
                case 'addFeaturedMedia':
                case 'saveParsingTemplate':
                case 'addSource':
                case 'addSrcSetAndSizes':
                case 'groupImagesRow':
                case 'sourceLinkIsNoFollow':
                //use json_decode to prevent "false" string converted to boolean true
                    $clean_data[$key]=boolval(json_decode($option));
                    break;
                case 'url':
                    $clean_data[$key]=esc_url_raw($option);
                    break;
                case 'sourceLinkCaption':
                    $clean_data[$key]=esc_html($option);
            }
        }
        return $clean_data;
    }
    /**
     * Sanitize  HTML template pattern array.
     *
     * @param array $template ['tagName','className','searchTemplate','children']
     * @return array
     */
    public function sanitizeHTMLtemplate($html_template)
    {
        $clean_data=$this->sanitizeTemplateElement($html_template);
        $clean_data['children']=array();
        foreach ($html_template['children'] as $child) {
            array_push($clean_data['children'], $this->sanitizeTemplateElement($child));
        }
        return $clean_data;
    }
    public function sanitizeTemplate($template)
    {
        return $clean_data=array(
            'template'=>$this->sanitizeHTMLtemplate($template['template']),
            'extraOptions'=>$this->sanitizeExtraOptions($template['extraOptions']),
            'url'=>\esc_url($template['url']),
            'postOptions'=>$this->sanitizePostOptions($template['postOptions']),
            'aiOptions'=>$this->sanitizeAIOptions($template['aiOptions'])
        );
    }
    public function sanitizeOptions($options)
    {
        return $clean_data=array(
            'extraOptions'=>$this->sanitizeExtraOptions($options['extraOptions']),
            'postOptions'=>$this->sanitizePostOptions($options['postOptions']),
            'aiOptions'=>$this->sanitizeAIOptions($options['aiOptions'])
        );
    }
    public function sanitizeParsedData($parsed_data)
    {
        return $clean_data=array(
            'title'=>esc_html($parsed_data['title']),
            //ToDo: add sanitize body method
            'body'=>$parsed_data['body'],
            'image'=>\esc_url($parsed_data['image']),
            'sourceUrl'=>\esc_url($parsed_data['sourceUrl']),
        );
    }
    protected function sanitizePostOptions($post_options){
        //ToDo: Implement post options sanitizing
        return $post_options;
    }
    protected function sanitizeAIOptions($ai_options){
        //ToDo: Implement AI options sanitizing
        return $ai_options;
    }
    /**
     * Sanitize child template element
     *
     * @param array $el  ['tagName','className','searchTemplate','position']
     * @return array
     */
    protected function sanitizeTemplateElement($el)
    {
        $clean_data=array();
        foreach ($el as $key => $param) {
            switch ($key) {
                case 'tagName':
                    $clean_data[$key]=preg_replace('/[^a-z0-9]/i', '', $param);
                    break;
                case 'className':
                    $clean_data[$key]=preg_replace('/[^a-zA-Z0-9\_\-]/i', '', $param);
                    break;
                case 'searchTemplate':
                    $clean_data[$key]=preg_replace('/[^a-zA-Z0-9\=\s\_\-\.\]\[]/i', '', $param);
                    break;
                case 'position':
                    $clean_data[$key]=preg_replace('/[^a-z0-9]/i', '', $param);
            }
        }
        return $clean_data;
    }
    public function sanitizeInteger($value){
        return intval($value);
    }
    /**
     * @return array
     */
    public function sanitizeCronOptions($option){
        $clean_data=array();
        $clean_data['maxCronCalls']=intval($option['maxCronCalls']);
        $clean_data['maxCronCalls']=$clean_data['maxCronCalls']>100?100:$clean_data['maxCronCalls'];
        $clean_data['maxPostsParsed']=intval($option['maxPostsParsed']);
        $clean_data['maxPostsParsed']=$clean_data['maxPostsParsed']>100?100:$clean_data['maxCronCalls'];
        $clean_data['interval']=preg_replace('/[^h,o,u,r,l,y,t,w,i,c,e,d,a,k]/i','',$option['interval']);
        return $clean_data;
    }
}