<?php
require 'includes/db.php';

// Fetch active ticket packages
$stmt = $pdo->query("SELECT * FROM ticket_packages WHERE is_active = 1 ORDER BY sort_order ASC");
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Get Tickets</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Secure your pass for the Global Pro Bono Summit Africa 2026</p>
    </div>
</div>

<main>
    <section class="section bg-white" style="padding-top: 2rem; padding-bottom: 4rem;">
        <div class="container" style="max-width: 1000px; margin: 0 auto;">
            
            <!-- Stepper Progress Bar -->
            <div class="stepper-header" style="display: flex; justify-content: space-between; margin-bottom: 3rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem; position: relative;">
                <div class="stepper-step active" id="step-nav-1" style="flex: 1; text-align: center; font-weight: 600; color: var(--primary-color);">
                    <div style="width: 30px; height: 30px; border-radius: 50%; background: var(--primary-color); color: white; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">1</div>
                    <div>Select Tickets</div>
                </div>
                <div class="stepper-step" id="step-nav-2" style="flex: 1; text-align: center; font-weight: 600; color: #cbd5e1;">
                    <div style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">2</div>
                    <div>Details</div>
                </div>
                <div class="stepper-step" id="step-nav-3" style="flex: 1; text-align: center; font-weight: 600; color: #cbd5e1;">
                    <div style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">3</div>
                    <div>Payment</div>
                </div>
                <div class="stepper-step" id="step-nav-4" style="flex: 1; text-align: center; font-weight: 600; color: #cbd5e1;">
                    <div style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">4</div>
                    <div>Confirmation</div>
                </div>
            </div>

            <form id="ticketingForm" enctype="multipart/form-data">
                
                <!-- STEP 1: SELECT TICKETS -->
                <div id="step-1" class="stepper-panel active">
                    <h3 style="font-size: 1.8rem; margin-bottom: 0.75rem; color: #0f172a;">Choose Your Pass</h3>
                    


                    <!-- GROUP 1: Main Delegate Passes -->
                    <h4 style="font-size: 1.1rem; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; margin-bottom: 1rem;"><i class="fa-solid fa-id-badge" style="margin-right: 0.5rem;"></i>Main Delegate Passes</h4>
                    
                    <?php
                    $eligibility = [
                        'EAC Members' => ['tag' => 'Kenya, Uganda, Tanzania, Rwanda, Burundi, South Sudan, DRC, Somalia', 'color' => '#16a34a', 'bg' => '#dcfce7'],
                        'GPBN Member' => ['tag' => 'Global Pro Bono Network Members', 'color' => '#2563eb', 'bg' => '#dbeafe'],
                        'Non Member' => ['tag' => 'Open to all delegates', 'color' => '#64748b', 'bg' => '#f1f5f9'],
                        'Academia/Government/Corporate' => ['tag' => 'Institutional delegates from academia, government, or corporates', 'color' => '#9333ea', 'bg' => '#f3e8ff'],
                        'Subsidised (Students & Youth below 30yrs)' => ['tag' => 'Must present valid student/youth ID at venue', 'color' => '#ea580c', 'bg' => '#fff7ed'],
                    ];
                    ?>
                    
                    <div class="ticket-list" style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2.5rem;">
                        <?php foreach($packages as $pkg): ?>
                        <?php if(!in_array($pkg['name'], ['Daily Rate', 'Sponsor a grassroot Pro Bono Subsidiary/StartUp leader from outside Kenya.'])): ?>
                        <?php $elig = $eligibility[$pkg['name']] ?? ['tag' => '', 'color' => '#64748b', 'bg' => '#f1f5f9']; ?>
                        <div class="ticket-row" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border: 1px solid #e2e8f0; border-radius: var(--border-radius-md); background: #f8fafc; transition: border-color 0.2s, box-shadow 0.2s;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 2px 8px rgba(22,101,52,0.08)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            <div style="flex: 1;">
                                <div style="font-weight: 700; font-size: 1.15rem; color: #0f172a;"><?php echo htmlspecialchars($pkg['name']); ?></div>
                                <div style="margin-top: 0.35rem;">
                                    <span style="display: inline-block; font-size: 0.8rem; font-weight: 600; color: <?php echo $elig['color']; ?>; background: <?php echo $elig['bg']; ?>; padding: 0.15rem 0.6rem; border-radius: 999px;"><?php echo htmlspecialchars($elig['tag']); ?></span>
                                </div>
                            </div>
                            <div style="text-align: right; margin-right: 2rem; min-width: 100px;">
                                <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary-color);">$<?php echo number_format($pkg['price_usd'], 2); ?></div>
                                <div style="font-size: 0.85rem; color: #64748b;">KES <?php echo number_format($pkg['price_kes'], 2); ?></div>
                            </div>
                            <div class="ticket-counter" style="display: flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: white;">
                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo $pkg['id']; ?>, -1)" style="padding: 0.5rem 1rem; background: #f1f5f9; border: none; cursor: pointer; font-weight: bold; color: #334155;">-</button>
                                <input type="number" id="qty_<?php echo $pkg['id']; ?>" name="qty[<?php echo $pkg['id']; ?>]" value="0" min="0" readonly style="width: 50px; text-align: center; border: none; font-weight: 600; pointer-events: none;">
                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo $pkg['id']; ?>, 1)" style="padding: 0.5rem 1rem; background: #f1f5f9; border: none; cursor: pointer; font-weight: bold; color: #334155;">+</button>
                                
                                <input type="hidden" id="name_<?php echo $pkg['id']; ?>" value="<?php echo htmlspecialchars($pkg['name']); ?>">
                                <input type="hidden" id="price_usd_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_usd']; ?>">
                                <input type="hidden" id="price_kes_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_kes']; ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- GROUP 2: Add-Ons & Daily Passes -->
                    <h4 style="font-size: 1.1rem; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; margin-bottom: 1rem; border-top: 2px solid #e2e8f0; padding-top: 2rem;"><i class="fa-solid fa-plus-circle" style="margin-right: 0.5rem;"></i>Add-Ons & Daily Passes</h4>
                    <div class="ticket-list" style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach($packages as $pkg): ?>
                        <?php if(in_array($pkg['name'], ['Daily Rate', 'Sponsor a grassroot Pro Bono Subsidiary/StartUp leader from outside Kenya.'])): ?>
                        <div class="ticket-row" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border: 1px solid #e2e8f0; border-radius: var(--border-radius-md); background: #f8fafc; transition: border-color 0.2s, box-shadow 0.2s;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 2px 8px rgba(22,101,52,0.08)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            <div style="flex: 1;">
                                <div style="font-weight: 700; font-size: 1.15rem; color: #0f172a;"><?php echo htmlspecialchars($pkg['name']); ?></div>
                                <div style="color: #64748b; font-size: 0.9rem; margin-top: 0.25rem;"><?php echo htmlspecialchars($pkg['description']); ?></div>
                            </div>
                            <div style="text-align: right; margin-right: 2rem; min-width: 100px;">
                                <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary-color);">$<?php echo number_format($pkg['price_usd'], 2); ?></div>
                                <div style="font-size: 0.85rem; color: #64748b;">KES <?php echo number_format($pkg['price_kes'], 2); ?></div>
                            </div>
                            <div class="ticket-counter" style="display: flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: white;">
                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo $pkg['id']; ?>, -1)" style="padding: 0.5rem 1rem; background: #f1f5f9; border: none; cursor: pointer; font-weight: bold; color: #334155;">-</button>
                                <input type="number" id="qty_<?php echo $pkg['id']; ?>" name="qty[<?php echo $pkg['id']; ?>]" value="0" min="0" readonly style="width: 50px; text-align: center; border: none; font-weight: 600; pointer-events: none;">
                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo $pkg['id']; ?>, 1)" style="padding: 0.5rem 1rem; background: #f1f5f9; border: none; cursor: pointer; font-weight: bold; color: #334155;">+</button>
                                
                                <input type="hidden" id="name_<?php echo $pkg['id']; ?>" value="<?php echo htmlspecialchars($pkg['name']); ?>">
                                <input type="hidden" id="price_usd_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_usd']; ?>">
                                <input type="hidden" id="price_kes_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_kes']; ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div style="margin-top: 2rem; background: white; padding: 1.5rem; border-top: 2px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 0.9rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Order Subtotal</div>
                            <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a;">$<span id="step1_total_usd">0.00</span> <span style="font-size: 1rem; color: #64748b; font-weight: 400;">(KES <span id="step1_total_kes">0.00</span>)</span></div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)" id="btn-next-1" disabled style="opacity: 0.5; cursor: not-allowed;">Proceed to Details &rarr;</button>
                    </div>
                </div>

                <!-- STEP 2: DETAILS -->
                <div id="step-2" class="stepper-panel hidden" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                        
                        <!-- Form -->
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 2rem;">
                            <h3 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Attendee Details</h3>
                            
                            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label class="form-label">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Mobile Phone Number *</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label class="form-label">Organization *</label>
                                    <input type="text" name="organization" id="organization" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Job Title</label>
                                    <input type="text" name="job_title" id="job_title" class="form-control">
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label class="form-label">Country *</label>
                                <select name="country" id="country" class="form-control" required>
                                    <option value="">Select Country...</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Other">Other...</option>
                                </select>
                            </div>

                            <h3 style="font-size: 1.2rem; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Logistics & Requirements</h3>
                            
                            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label class="form-label">Dietary Requirements</label>
                                    <select name="dietary_requirements" class="form-control">
                                        <option value="None">None</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Vegan">Vegan</option>
                                        <option value="Halal">Halal</option>
                                        <option value="Kosher">Kosher</option>
                                        <option value="Gluten-Free">Gluten-Free</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Require Visa Letter?</label>
                                    <select name="visa_required" id="visa_required" class="form-control" onchange="togglePassport()">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div id="passport_field" style="margin-bottom: 1rem; display: none;">
                                <label class="form-label">Passport Number (Required for Visa Letter) *</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control">
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label class="form-label">Accessibility or other special requirements?</label>
                                <textarea name="accessibility_needs" class="form-control" rows="2"></textarea>
                            </div>

                            <h3 style="font-size: 1.2rem; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Emergency Contact</h3>
                            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                                <div>
                                    <label class="form-label">Name</label>
                                    <input type="text" name="emergency_contact_name" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="emergency_contact_phone" class="form-control">
                                </div>
                            </div>

                        </div>

                        <!-- Sidebar -->
                        <div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 1.5rem; position: sticky; top: 100px;">
                                <h4 style="font-size: 1.2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 0.5rem;">Order Summary</h4>
                                <div id="sidebar_cart_items" style="margin-bottom: 1rem;">
                                    <!-- Populated by JS -->
                                </div>
                                
                                <div style="border-top: 1px solid #cbd5e1; padding-top: 1rem; margin-bottom: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #64748b;">
                                        <span>Subtotal</span>
                                        <span>$<span id="sidebar_subtotal_usd">0.00</span></span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #ef4444; display: none;" id="discount_row">
                                        <span>Discount</span>
                                        <span>-$<span id="sidebar_discount_usd">0.00</span></span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.2rem; color: #0f172a; margin-top: 0.5rem;">
                                        <span>Total</span>
                                        <span>$<span id="sidebar_total_usd">0.00</span></span>
                                    </div>
                                    <div style="text-align: right; font-size: 0.85rem; color: #64748b;">
                                        KES <span id="sidebar_total_kes">0.00</span>
                                    </div>
                                </div>

                                <div style="margin-bottom: 1.5rem;">
                                    <label class="form-label" style="font-size: 0.85rem;">Promo Code</label>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <input type="text" id="promo_code_input" name="promo_code" class="form-control" style="padding: 0.5rem; font-size: 0.9rem;" placeholder="Enter code">
                                        <button type="button" class="btn btn-outline" style="padding: 0.5rem 1rem;" onclick="applyPromo()">Apply</button>
                                    </div>
                                    <div id="promo_msg" style="font-size: 0.8rem; margin-top: 0.25rem;"></div>
                                </div>
                                
                                <input type="hidden" id="discount_usd_val" name="discount_usd" value="0">
                                <input type="hidden" id="discount_kes_val" name="discount_kes" value="0">

                                <div style="display: flex; gap: 1rem;">
                                    <button type="button" class="btn btn-outline" style="flex: 1;" onclick="nextStep(1)">&larr; Back</button>
                                    <button type="button" class="btn btn-primary" style="flex: 2;" onclick="validateStep2AndProceed()">Proceed to Payment &rarr;</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- STEP 3: PAYMENT -->
                <div id="step-3" class="stepper-panel hidden" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                        
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 2rem;">
                            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #0f172a;">Manual Bank Transfer</h3>
                            <p style="color: #64748b; margin-bottom: 0.5rem; line-height: 1.6;">To complete your order, please transfer the total amount to the bank account below.</p>
                            <div style="background: #eef2ff; border: 1px solid #c7d2fe; padding: 1rem; border-radius: 6px; margin-bottom: 2rem;">
                            <div style="background: #f1f5f9; border-left: 4px solid var(--primary-color); padding: 1.5rem; border-radius: 0 8px 8px 0; margin-bottom: 2rem;">
                                <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 1rem; font-weight: 700;">Secure Checkout</h4>
                                <p style="color: #334155; line-height: 1.6; margin-bottom: 1rem;">
                                    By clicking the "Pay Securely" button below, you will be redirected to our secure payment partner, <strong>Paystack</strong>, to complete your transaction.
                                </p>
                                <p style="color: #334155; line-height: 1.6; margin-bottom: 0;">
                                    You can pay easily using your preferred method (Card, Mobile Money, etc.) in KES or USD. Once payment is successful, you will be redirected back here for your confirmation.
                                </p>
                            </div>
                            
                        </div>

                        <!-- Sidebar copy -->
                        <div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 1.5rem; position: sticky; top: 100px;">
                                <h4 style="font-size: 1.2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 0.5rem;">Amount Due</h4>
                                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color); margin-bottom: 0.5rem;">$<span id="final_total_usd">0.00</span></div>
                                <div style="font-size: 1.1rem; color: #64748b; margin-bottom: 1.5rem;">KES <span id="final_total_kes">0.00</span></div>
                                
                                <div style="display: flex; gap: 1rem; flex-direction: column;">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem; background-color: #09a5db; border-color: #09a5db;" id="submitBtn"><i class="fa-solid fa-lock"></i> Pay Securely with Paystack</button>
                                    <button type="button" class="btn btn-outline" style="width: 100%;" onclick="nextStep(2)">&larr; Back to Details</button>
                                </div>
                                <div style="margin-top: 1rem; text-align: center; font-size: 0.8rem; color: #94a3b8;">
                                    By submitting, you agree to our Terms & Conditions.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- STEP 4: CONFIRMATION -->
                <div id="step-4" class="stepper-panel hidden" style="display: none; text-align: center; padding: 4rem 2rem;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; font-size: 2.5rem; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2 style="font-size: 2.5rem; color: #0f172a; margin-bottom: 1rem;">Booking Received!</h2>
                    <p style="font-size: 1.1rem; color: #64748b; max-width: 600px; margin: 0 auto 2rem;">Your order has been successfully placed. An email confirmation has been sent to you along with the bank account details.</p>
                    
                    <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 1.5rem; max-width: 400px; margin: 0 auto 2rem;">
                        <div style="font-size: 0.9rem; color: #64748b; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Order Reference</div>
                        <div id="success_order_ref" style="font-size: 1.8rem; font-weight: 800; color: var(--primary-color); letter-spacing: 2px;">GPBS-XXXXXX</div>
                    </div>

                    <h4 style="font-size: 1.2rem; color: #0f172a; margin-bottom: 1rem;">Next Steps:</h4>
                    <ol style="text-align: left; max-width: 500px; margin: 0 auto 3rem; color: #334155; line-height: 1.8; font-size: 1.05rem;">
                        <li>Check your email for the order confirmation.</li>
                        <li>Make the bank transfer using the order reference above as the narration.</li>
                        <li>Upload your proof of payment via the link in your email (if you haven't already).</li>
                        <li>Receive your final e-ticket once our team verifies the payment.</li>
                    </ol>

                    <a href="index.php" class="btn btn-outline">Return to Homepage</a>
                </div>

            </form>
        </div>
    </section>

    <!-- UI Overlay for loading -->
    <div id="loaderOverlay" style="display:none; position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(255,255,255,0.9); z-index: 9999; flex-direction: column; align-items: center; justify-content: center;">
        <div class="spinner" style="border: 4px solid #e2e8f0; border-top: 4px solid var(--primary-color); border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin-bottom: 1rem;"></div>
        <div style="font-weight: 600; color: #0f172a; font-size: 1.1rem;">Processing Order...</div>
        <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
    </div>
</main>

<style>
    .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155; font-size: 0.95rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 6px; font-family: var(--font-body); font-size: 1rem; transition: all 0.2s; background: white; }
    .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1); }
    
    @media (max-width: 768px) {
        .ticket-row {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1.5rem !important;
        }
        .ticket-row > div:nth-child(2) {
            text-align: left !important;
            margin-right: 0 !important;
        }
        .ticket-row .ticket-counter {
            align-self: flex-start !important;
            width: 100% !important;
            justify-content: space-between !important;
        }
        .ticket-row .qty-btn {
            flex: 1 !important;
        }
        .ticket-row input[type="number"] {
            flex: 1 !important;
        }
    }
</style>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    let cart = {};
    let subtotalUsd = 0;
    let subtotalKes = 0;
    
    function updateQty(id, delta) {
        const input = document.getElementById('qty_' + id);
        let val = parseInt(input.value) + delta;
        if(val < 0) val = 0;
        input.value = val;
        
        const name = document.getElementById('name_' + id).value;
        const priceUsd = parseFloat(document.getElementById('price_usd_' + id).value);
        const priceKes = parseFloat(document.getElementById('price_kes_' + id).value);
        
        if (val > 0) {
            cart[id] = { name, priceUsd, priceKes, qty: val };
        } else {
            delete cart[id];
        }
        
        recalculateTotals();
    }
    
    function recalculateTotals() {
        subtotalUsd = 0;
        subtotalKes = 0;
        
        let sidebarHtml = '';
        
        for (const [id, item] of Object.entries(cart)) {
            const itemTotalUsd = item.priceUsd * item.qty;
            const itemTotalKes = item.priceKes * item.qty;
            subtotalUsd += itemTotalUsd;
            subtotalKes += itemTotalKes;
            
            sidebarHtml += `
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                    <div><span style="font-weight: 700;">${item.qty}x</span> ${item.name}</div>
                    <div style="font-weight: 600;">$${itemTotalUsd.toFixed(2)}</div>
                </div>
            `;
        }
        
        if (Object.keys(cart).length === 0) {
            sidebarHtml = '<div style="color: #94a3b8; font-size: 0.9rem; font-style: italic;">No tickets selected.</div>';
            document.getElementById('btn-next-1').disabled = true;
            document.getElementById('btn-next-1').style.opacity = '0.5';
            document.getElementById('btn-next-1').style.cursor = 'not-allowed';
        } else {
            document.getElementById('btn-next-1').disabled = false;
            document.getElementById('btn-next-1').style.opacity = '1';
            document.getElementById('btn-next-1').style.cursor = 'pointer';
        }
        
        document.getElementById('step1_total_usd').innerText = subtotalUsd.toFixed(2);
        document.getElementById('step1_total_kes').innerText = subtotalKes.toFixed(2);
        
        document.getElementById('sidebar_cart_items').innerHTML = sidebarHtml;
        document.getElementById('sidebar_subtotal_usd').innerText = subtotalUsd.toFixed(2);
        
        applyDiscounts();
    }
    
    function applyDiscounts() {
        let discountUsd = parseFloat(document.getElementById('discount_usd_val').value) || 0;
        let discountKes = parseFloat(document.getElementById('discount_kes_val').value) || 0;
        
        if (discountUsd > subtotalUsd) discountUsd = subtotalUsd;
        if (discountKes > subtotalKes) discountKes = subtotalKes;
        
        if (discountUsd > 0) {
            document.getElementById('discount_row').style.display = 'flex';
            document.getElementById('sidebar_discount_usd').innerText = discountUsd.toFixed(2);
        } else {
            document.getElementById('discount_row').style.display = 'none';
        }
        
        const finalUsd = subtotalUsd - discountUsd;
        const finalKes = subtotalKes - discountKes;
        
        document.getElementById('sidebar_total_usd').innerText = finalUsd.toFixed(2);
        document.getElementById('sidebar_total_kes').innerText = finalKes.toFixed(2);
        document.getElementById('final_total_usd').innerText = finalUsd.toFixed(2);
        document.getElementById('final_total_kes').innerText = finalKes.toFixed(2);
    }
    
    function applyPromo() {
        const code = document.getElementById('promo_code_input').value.trim();
        const msgBox = document.getElementById('promo_msg');
        if (!code) {
            msgBox.innerHTML = '<span style="color:#ef4444;">Enter a code</span>';
            return;
        }
        
        msgBox.innerHTML = '<span style="color:#64748b;">Checking...</span>';
        
        fetch('ajax_ticket_order.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=validate_promo&code=' + encodeURIComponent(code)
        })
        .then(r => r.json())
        .then(data => {
            if (data.valid) {
                msgBox.innerHTML = '<span style="color:#16a34a;">Promo applied!</span>';
                document.getElementById('discount_usd_val').value = data.discount_usd;
                document.getElementById('discount_kes_val').value = data.discount_kes;
                applyDiscounts();
            } else {
                msgBox.innerHTML = '<span style="color:#ef4444;">Invalid or expired code</span>';
                document.getElementById('discount_usd_val').value = 0;
                document.getElementById('discount_kes_val').value = 0;
                applyDiscounts();
            }
        }).catch(err => {
            msgBox.innerHTML = '<span style="color:#ef4444;">Error checking code</span>';
        });
    }

    function togglePassport() {
        const val = document.getElementById('visa_required').value;
        const passportField = document.getElementById('passport_field');
        if(val === '1') {
            passportField.style.display = 'block';
            document.getElementById('passport_number').required = true;
        } else {
            passportField.style.display = 'none';
            document.getElementById('passport_number').required = false;
        }
    }

    function nextStep(step) {
        document.querySelectorAll('.stepper-panel').forEach(p => { p.style.display = 'none'; p.classList.remove('active'); });
        const target = document.getElementById('step-' + step);
        target.style.display = 'block';
        setTimeout(() => target.classList.add('active'), 10); // for transition
        
        // Update nav dots
        for(let i=1; i<=4; i++) {
            const nav = document.getElementById('step-nav-' + i);
            const num = nav.querySelector('div');
            if(i < step) {
                nav.style.color = 'var(--primary-color)';
                num.style.background = 'var(--primary-color)';
                num.style.color = 'white';
                num.innerHTML = '<i class="fa-solid fa-check"></i>';
            } else if (i === step) {
                nav.style.color = 'var(--primary-color)';
                num.style.background = 'var(--primary-color)';
                num.style.color = 'white';
                num.innerHTML = i;
            } else {
                nav.style.color = '#cbd5e1';
                num.style.background = '#e2e8f0';
                num.style.color = '#64748b';
                num.innerHTML = i;
            }
        }
        
        window.scrollTo({top: document.getElementById('step-nav-1').offsetTop - 100, behavior: 'smooth'});
    }

    function validateStep2AndProceed() {
        const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'organization', 'country'];
        let valid = true;
        requiredFields.forEach(f => {
            const el = document.getElementById(f);
            if(!el.value.trim()) {
                el.style.borderColor = '#ef4444';
                valid = false;
            } else {
                el.style.borderColor = '#cbd5e1';
            }
        });
        
        if (document.getElementById('visa_required').value === '1') {
            const pass = document.getElementById('passport_number');
            if(!pass.value.trim()) {
                pass.style.borderColor = '#ef4444';
                valid = false;
            }
        }
        
        if(valid) {
            nextStep(3);
        } else {
            alert("Please fill in all required fields (marked with *).");
        }
    }

    document.getElementById('ticketingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        document.getElementById('loaderOverlay').style.display = 'flex';
        
        const formData = new FormData(this);
        formData.append('action', 'submit_order');
        formData.append('subtotal_usd', subtotalUsd);
        formData.append('subtotal_kes', subtotalKes);
        
        // the discount values are already in hidden inputs inside the form
        
        fetch('ajax_ticket_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loaderOverlay').style.display = 'none';
            if(data.success && data.total_kes > 0) {
                // Initialize Paystack Inline
                let handler = PaystackPop.setup({
                    key: 'pk_test_6578aa473fa44adafd06040f9ce9507ed9c9fd90',
                    email: data.email,
                    amount: data.total_kes * 100, // in kobo/cents
                    currency: 'KES',
                    ref: data.order_ref,
                    callback: function(response) {
                        // verify the transaction with backend
                        document.getElementById('loaderOverlay').style.display = 'flex';
                        let verifyForm = new FormData();
                        verifyForm.append('reference', response.reference);
                        
                        fetch('ajax_verify_payment.php', {
                            method: 'POST',
                            body: verifyForm
                        })
                        .then(res => res.json())
                        .then(verifyData => {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            if (verifyData.success) {
                                document.getElementById('success_order_ref').innerText = data.order_ref;
                                nextStep(4);
                            } else {
                                alert('Payment verification failed: ' + verifyData.message);
                            }
                        })
                        .catch(err => {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            alert('An error occurred during verification.');
                        });
                    },
                    onClose: function() {
                        alert('Payment cancelled. You can try again by clicking Pay Securely.');
                    }
                });
                handler.openIframe();
            } else if (data.success && data.total_kes <= 0) {
                // Fallback if total is 0
                document.getElementById('success_order_ref').innerText = data.order_ref;
                nextStep(4);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            document.getElementById('loaderOverlay').style.display = 'none';
            alert('An unexpected error occurred. Please try again.');
        });
    });

</script>

<?php include 'includes/footer.php'; ?>
