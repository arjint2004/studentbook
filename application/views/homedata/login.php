<form method="get" action="#">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <p>
                            <input type="text" class="textbox" name="name">
                            <label> Your Name <span> * </span> </label>
                        </p>
                        
                        <p>
                            <input type="text" class="textbox" name="name">
                            <label> Email <span> * </span> </label>
                        </p>
                        
                        <p>
                            <input type="text" class="textbox" name="name">
                            <label> Website </label>
                        </p>
                        
                        <p>
                            <textarea rows="" cols="" name="comment"></textarea>
                        </p>
                        
                        <p>
                            <input type="button" class="button small grey" value="Submit Comment" name="submit">
                        </p>
                    
                    </form>