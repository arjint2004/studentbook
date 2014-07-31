<?=$this->load->view('layout/ad_header')?>
    <!-- **Welcome Text** -->
    <style>
    ol li .list{
        font-weight:bold;
    }
    </style>
    <div class="welcome-text">
    	<div class="container">
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
            
                <h1 class="with-subtitle"> Contact Page </h1>
                <h6 class="subtitle">  Page subtitle goes here </h6>
                
                <p class="contact-info"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer velit enim, consequat pellentesque pellentesque ac, rutrum sed enim. Pellentesque interdum pharetra urna,
                vitae dapibus metus vulputate sed. </p>
                
                <div class="column one-half">
                    <h3> Send us an Email </h3>
                        <div class="ajax_message"></div>
                        <form class="sendmail" action="php/sendmail.php" method="get">
                            <p>
                                <label> Your Name <span class="required"> * </span> </label>
                                <input name="name" type="text" />
                            </p>
                            <p>
                                <label> Your Email <span class="required"> * </span> </label>
                                <input name="email" type="text" />
                            </p>
                            <p>
                                <label> Subject </label>
                                <input name="subject" type="text" />
                            </p>
                            <p>
                                <label> Your Message </label>
                                <textarea name="message" cols="" rows=""></textarea>
                            </p>
                            <p><input name="submit" type="submit" value="Send Message" class="button small grey" style='float:left'/></p>
                    </form>
                    <div class="error-container" style="display:none;"> Please fill the above required fields! </div>
                </div>
            </div> <!-- **Content Full Width - End** -->  
        </div>
    </div><!-- **Welcome Text End** -->

<?=$this->load->view('layout/ad_footer')?>
