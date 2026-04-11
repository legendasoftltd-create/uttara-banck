
<div class="header make-sticky">
    <!-- Navbar Start-->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <a href="<?php echo e(url('/')); ?>">
                    <?php if(!empty(filter_static_option_value('site_logo', $global_static_field_data))): ?>
                        <?php echo render_image_markup_by_attachment_id(filter_static_option_value('site_logo', $global_static_field_data)); ?>

                    <?php else: ?>
                        <h2 class="site-title">
                            <?php echo e(filter_static_option_value('site_' . $user_select_lang_slug . '_title', $global_static_field_data)); ?>

                        </h2>
                    <?php endif; ?>
                </a>
            </div>

            <nav class="center-menu">
                <?php $__currentLoopData = get_product_category_on_menu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('frontend.products.category',['id' => $data->id, 'any' => $data->title])); ?>" class="animateButton_button___WZrU">
                        <div class="animateButton_fill__8C9aZ"></div>
                        <span class="animateButton_text__mb1az"><?php echo e($data->title); ?></span>
                    </a>
                    <span>|</span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('frontend.service')); ?>" class="animateButton_button___WZrU">
                    <div class="animateButton_fill__8C9aZ"></div>
                    <span class="animateButton_text__mb1az">Services</span>
                </a>
            </nav>

            <div class="right-menu">
                <div class="search-box">
                    <div class="search-icon" id="searchBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="black" stroke-width="2"
                                fill="none" />
                            <line x1="16" y1="16" x2="21" y2="21" stroke="black"
                                stroke-width="2" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Search..." id="searchInput">
                </div>
                <!-- <div class="lang">
                                <button class="active">EN</button>
                                <button>BN</button>
                            </div> -->
                <div class="phone">
                    <a href="to:16645"> ☎ 16645 </a>
                </div>
                <a class="btn ibanking">iBanking</a>
                <div class="hamburger" id="menuBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

            </div>

        </div>
        <nav class="d-block d-md-none text-center center-menu">
            <a href="#">Retail</a>
            <span>|</span>
            <a href="sme.html">SME</a>
            <span>|</span>
            <a href="#">Corporate</a>
        </nav>
    </header>

    <!-- SIDE MENU -->

            <div class="side-menu" id="sideMenu">
                <div class="menu-header">
                    <div class="close text-black" id="closeMenu">✕</div>
                </div>
                <ul>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">About Us</a>
                        <ul class="sub-menu">
                            <li><a href="about.html#atGlance">Bank at a Glance</a></li>
                            <li><a href="about.html#historyUBPLC">History of Uttara Bank PLC.</a></li>
                            <li><a href="about.html#bod">Board of Directors</a></li>
                            <li><a href="about.html#executive-committee">Executive Committee</a></li>
                            <li><a href="about.html#audit-committee">Audit Committee</a></li>
                            <li><a href="about.html#risk-management-committee">Risk Management Committee</a></li>
                            <li><a href="about.html#senior-management">Senior Management</a></li>
                            <li><a href="#">Employee Information</a></li>
                            <li><a href="#">Shareholding Structure</a></li>
                            <li><a href="#">Government Securities Investment Window</a></li>
                            <li><a href="#">Cash Dollar Transaction</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Loan Product</a>
                        <ul class="sub-menu">
                            <li><a href="#">Uttaran Small Business Loan (USBL)</a></li>
                            <li><a href="#">Nari Swanirbor Rin Prokalpo (NSRP)</a></li>
                            <li><a href="#">Uttaran SME Sector Development Project Loan (USSDPL)</a></li>
                            <li><a href="#">UBPLC Staff Credit - Personal Loan</a></li>
                            <li><a href="#">Uttaran House Repairing / Renovation Loan</a></li>
                            <li><a href="#">House Hold Durables</a></li>
                            <li><a href="#">Consumer Credit – Personal Loan</a></li>
                            <li><a href="#">Loan for Foreign Employment</a></li>
                            <li><a href="#">Doctor’s Loan</a></li>
                            <li><a href="#">Education Loan</a></li>
                            <li><a href="#">Marriage Loan</a></li>
                            <li><a href="#">Travel Loan</a></li>
                            <li><a href="#">House Finance for Freedom Fighters</a></li>
                            <li><a href="#">Uttaran Home Loan</a></li>
                            <li><a href="#">Car/Motorcycle Loan</a></li>
                            <li><a href="#">Trade Finance</a></li>
                            <li><a href="#">Green Financing</a></li>
                            <li><a href="#">Agricultural Credit</a></li>
                            <li><a href="#">Lease Finance</a></li>
                            <li><a href="#">Fixed Term Loan to Enterprise</a></li>
                            <li><a href="#">Working Capital Loan</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Deposit Product</a>
                        <ul class="sub-menu">
                            <li><a href="#">Savings Bank Account (Clients)</a></li>
                            <li><a href="#">Uttaran Kotipoti Deposit Scheme</a></li>
                            <li><a href="#">Savings Bank Account (School Banking)</a></li>
                            <li><a href="#">Savings Bank Account (Garments Workers)</a></li>
                            <li><a href="#">Double Benefit Deposit Scheme</a></li>
                            <li><a href="#">Savings Bank Account (Farmers)</a></li>
                            <li><a href="#">Savings Bank Account (Leather Factory Workers)</a></li>
                            <li><a href="#">Uttaran Lakhpoti Deposit Scheme</a></li>
                            <li><a href="#">Uttaran Millionaire Deposit Scheme</a></li>
                            <li><a href="#">Bank Account (Non Privileged Farmers, Woman & Young Entrepreneurs)</a></li>
                            <li><a href="#">Special Notice Deposit</a></li>
                            <li><a href="#">Uttaran Physically Challenged Persons SB A/C</a></li>
                            <li><a href="#">Uttaran Street Urchin and Working Children SB A/C</a></li>
                            <li><a href="#">Fixed Deposit Receipt Account</a></li>
                            <li><a href="#">Current Account (Non-Individual)</a></li>
                            <li><a href="#">Under Privileged SB A/C</a></li>
                            <li><a href="#">Monthly Deposit Scheme (MDS)</a></li>
                            <li><a href="#">Current Account (Individual)</a></li>
                            <li><a href="#">Uttaran Swapnapuran Sanchaya Prokolpa</a></li>
                            <li><a href="#">Uttaran Bibaha Sanchaya Prokolpa</a></li>
                            <li><a href="#">Mashik Munafa Prokalpa</a></li>
                            <li><a href="#">Uttaran Taka 10 SB Account</a></li>
                            <li><a href="#">Uttaran Footwear and Leather Products Workers SB A/C</a></li>
                            <li><a href="#">National Service Programme SB A/C</a></li>
                            <li><a href="#">The inhabitants of earlier enclaves taka 10 SB A/C</a></li>
                            <li><a href="#">Uttaran Five Million Deposit Scheme</a></li>
                            <li><a href="#">Uttaran Labonya Deposit Scheme</a></li>
                            <li><a href="#">Uttaran Probashi Deposit Scheme</a></li>
                            <li><a href="#">‘UB 100 days FDR’, ‘UB 200 days FDR’ and ‘UB 300 days FDR’</a></li>
                            <li><a href="#">Uttaran Shohoz Bazar Scheme (USBS)</a></li>
                            <li><a href="#">Uttaran Swanirbhar Shanchaya Scheme (USSS)</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Our Services</a>
                        <ul class="sub-menu">
                            <li><a href="#">International Division</a></li>
                            <li><a href="#">International Trade Services</a></li>
                            <li><a href="#">Risk Management Department</a></li>
                            <li><a href="#">Treasury Service</a></li>
                            <li><a href="#">AD Branches</a></li>
                            <li><a href="#">Foreign Currency Account</a></li>
                            <li><a href="#">NFCD Account</a></li>
                            <li><a href="#">RFCD Account</a></li>
                            <li><a href="#">Standard Settlement Instruction</a></li>
                            <li><a href="#">Off - Shore Banking Unit</a></li>
                            <li><a href="#">Exchange Rate</a></li>
                            <li><a href="#">FDI Help Desk</a></li>
                            <li><a href="#">Government Securities Investment Window</a></li>
                            <li><a href="#">Cash Dollar Transaction</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Financial Reports</a>
                        <ul class="sub-menu">
                            <li><a href="#">Annual Reports</a></li>
                            <li><a href="#">1st Quarter Statement</a></li>
                            <li><a href="#">Half Yearly Statement</a></li>
                            <li><a href="#">3rd Quarter Statement</a></li>
                            <li><a href="#">Credit Rating</a></li>
                            <li><a href="#">Disclosures on Risk Based Capital</a></li>
                            <li><a href="#">Disclosures on Green Banking</a></li>
                            <li><a href="#">Important Disclosure</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Schedule of Charges</a>
                        <ul class="sub-menu">
                            <li><a href="#">Inland Transaction</a></li>
                            <li><a href="#">Foreign Exchange Transaction</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Media Room</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo e(route('frontend.news')); ?>">News</a></li>
                            <li><a href="#">Auction</a></li>
                            <li><a href="#">Notice</a></li>
                            <li><a href="#">Downloads</a></li>
                            <li><a href="#">Photo Gallery</a></li>
                            <li><a href="#">Video Gallery</a></li>
                            <li><a href="#">Useful Link</a></li>
                            <li><a href="#">Tender</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-toggle">Others</a>
                        <ul class="sub-menu">
                            <li><a href="#">Interest Rate</a></li>
                            <li><a href="#">e-GP</a></li>
                            <li><a href="#">Eligible Capital</a></li>
                            <li><a href="#">Tax Return Notice</a></li>
                            <li><a href="#">Code of Conduct</a></li>
                            <li><a href="#">Financial Literacy</a></li>
                            <li><a href="#">Cautionary Notice</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo e(route('frontend.locations')); ?>">Our Location</a></li>
                    <li><a href="#">iBanking</a></li>
                    <li><a href="https://play.google.com/store/apps/details?id=com.uttarabank.ublmobile">Uttara
                            eWallet</a></li>
                    <li><a href="#">Career</a></li>
                    <li><a href="#">Complain</a></li>
                    <li><a href="#">Warning against illegal forex trading/dealing</a></li>
                    <li><a href="#">National Integrity Strategy</a></li>
                    <li><a href="#">Sanchayapatra</a></li>
                    <li><a href="#">Unclaimed Deposit List</a></li>
                    <li><a href="#">Financial Literacy</a></li>
                    <li><a href="#">Digital Banking</a></li>
                    <li><a href="#">Unclaimed Dividend</a></li>
                    <li><a href="#">Citizen's Charter</a></li>
                    <li><a href="#">FDI Help Desk</a></li>
                    <li><a href="#">Lending Interest Rate</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="overlay" id="overlay"></div>
            <!-- Navbar End-->
</div>
<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/navbar.blade.php ENDPATH**/ ?>