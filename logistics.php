<?php include 'includes/header.php'; ?>

<div class="page-header" style="background: linear-gradient(rgba(22, 101, 52, 0.85), rgba(22, 101, 52, 0.9)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Logistics & Travel Guide</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Comprehensive support for our international and regional delegates.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <!-- 1. Visa & Entry -->
            <div id="visa" class="logistics-block" style="margin-bottom: 4rem; scroll-margin-top: 5rem;">
                <h2 style="color: var(--primary-color); border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; margin-bottom: 2rem;">1. Visa & Entry Requirements</h2>
                <div class="grid-2-col">
                    <div>
                        <p class="lead-text">Kenya Electronic Travel Authorization (eTA)</p>
                        <p>All foreign nationals crossing the Kenyan border for the Global Pro-bono Summit Africa 2026 must hold a valid eTA or Visa (dependent on origin). The Kenyan government has streamlined this process entirely online.</p>
                        <ul class="feature-list">
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Processing Time:</strong> Typically 3-5 business days.</li>
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Summit Invitation Letters:</strong> Generated automatically within 48 hours upon successful registration approval.</li>
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Yellow Fever Certificate:</strong> Required if arriving from endemic zones.</li>
                        </ul>
                        <a href="https://www.etakenya.go.ke/en" target="_blank" class="btn btn-outline" style="border-color: var(--primary-color); color: var(--primary-color); margin-top: 1rem;">Official Kenya eTA Portal &rarr;</a>
                    </div>
                    <div style="background: var(--bg-alt); padding: 2rem; border-radius: var(--border-radius-md); border-left: 4px solid var(--secondary-color);">
                        <h4>Need Embassy Assistance?</h4>
                        <p style="font-size: 0.95rem; margin-top: 1rem;">If your local Kenyan embassy requires a physical letter of guarantee stamped by a recognized NGO, the Jitolee Good Friends Foundation legal team will express post this prior to October 1st.</p>
                        <p style="font-size: 0.95rem;">Contact: <strong>logistics@summitafrica.org</strong></p>
                    </div>
                </div>
            </div>
            
            <!-- 2. Accommodation -->
            <div id="accommodation" class="logistics-block" style="margin-bottom: 4rem; scroll-margin-top: 5rem;">
                <h2 style="color: var(--primary-color); border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; margin-bottom: 2rem;">2. Preferred Event Accommodations</h2>
                <p style="margin-bottom: 2rem;">We have partnered with leading highly-rated Nairobi hotels positioned within 5 kilometers of the primary venues (KICC, UON). Registered delegates using the unique code <strong style="color: var(--secondary-color);">PROBONO26</strong> receive up to 25% off standard rates.</p>
                
                <style>
                    .hotel-table { width: 100%; border-collapse: collapse; text-align: left; }
                    .hotel-table th, .hotel-table td { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
                    .hotel-table th { background-color: var(--bg-alt); font-family: var(--font-heading); color: var(--text-main); }
                    .hotel-table tr:hover { background-color: #f8fafc; }
                </style>
                <div style="overflow-x: auto;">
                    <table class="hotel-table">
                        <thead>
                            <tr>
                                <th>Hotel Partner</th>
                                <th>Star Rating</th>
                                <th>Proximity to KICC</th>
                                <th>Summit Rate (Nightly)</th>
                                <th>Amenities Included</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>The Stanley Nairobi</strong></td>
                                <td style="color: #fbbf24; font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></td>
                                <td>1.2 km (Shuttle provided)</td>
                                <td>$185 USD</td>
                                <td>Breakfast, High-speed Wi-Fi, Pool, Gym</td>
                            </tr>
                            <tr>
                                <td><strong>Nairobi Serena Hotel</strong></td>
                                <td style="color: #fbbf24; font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></td>
                                <td>1.8 km (Shuttle provided)</td>
                                <td>$210 USD</td>
                                <td>Breakfast, Spa access, Executive Lounge</td>
                            </tr>
                            <tr>
                                <td><strong>Panari Hotel</strong></td>
                                <td style="color: #fbbf24; font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></td>
                                <td>2.5 km (Shuttle provided)</td>
                                <td>$130 USD</td>
                                <td>Breakfast, Wi-Fi, Gym</td>
                            </tr>
                            <tr>
                                <td><strong>Ibis Styles Nairobi</strong></td>
                                <td style="color: #fbbf24; font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></td>
                                <td>4.0 km (Shuttle provided)</td>
                                <td>$85 USD</td>
                                <td>Breakfast, Basic Wi-Fi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Ground Transport -->
            <div id="transport" class="logistics-block" style="margin-bottom: 4rem; scroll-margin-top: 5rem;">
                <h2 style="color: var(--primary-color); border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; margin-bottom: 2rem;">3. VIP Transport & Ground Navigation</h2>
                <div class="grid-3-col">
                    <div class="value-card" style="box-shadow: none; border: 1px solid #e2e8f0; text-align: left;">
                        <div class="icon-wrapper" style="width: 50px; height: 50px; margin-bottom: 1rem; font-size: 1.5rem;"><i class="fa-solid fa-plane"></i></div>
                        <h3>Airport Transfers</h3>
                        <p>Complimentary VIP shuttle buses will run continuously from Jomo Kenyatta International Airport (JKIA) to Partner Hotels on October 10th and 11th. Look for the Jitolee Foundation kiosks at Arrivals.</p>
                    </div>
                    <div class="value-card" style="box-shadow: none; border: 1px solid #e2e8f0; text-align: left;">
                        <div class="icon-wrapper" style="width: 50px; height: 50px; margin-bottom: 1rem; font-size: 1.5rem;"><i class="fa-solid fa-van-shuttle"></i></div>
                        <h3>Inter-Venue Shuttles</h3>
                        <p>The 4 primary locations (UON, KRA Hall, KICC, Safari Club) are linked by a secure luxury bus loop running every 15 minutes during summit operational hours (07:00 - 20:00).</p>
                    </div>
                    <div class="value-card" style="box-shadow: none; border: 1px solid #e2e8f0; text-align: left;">
                        <div class="icon-wrapper" style="width: 50px; height: 50px; margin-bottom: 1rem; font-size: 1.5rem;"><i class="fa-solid fa-taxi"></i></div>
                        <h3>Private Taxi Integrations</h3>
                        <p>Nairobi is highly integrated with ride-share apps. Uber and Bolt operate reliably across the city. Dedicated safe drop-off zones have been established at all 4 venues for private vehicles.</p>
                    </div>
                </div>
            </div>

            <!-- 4. Post-Summit Tourism (NEW Section) -->
            <div id="tourism" class="logistics-block" style="margin-bottom: 4rem; scroll-margin-top: 5rem;">
                <h2 style="color: var(--primary-color); border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; margin-bottom: 2rem;">4. Post-Summit Tourism & Safaris</h2>
                <div class="grid-2-col align-center">
                    <div>
                        <p class="lead-text">Extend your stay in Magical Kenya</p>
                        <p style="margin-bottom: 1.5rem;">After the Global Pro-bono Summit concludes, we highly encourage delegates to experience the breathtaking beauty of Kenya. Our concierge team assists interested parties in facilitating bespoke short-tours at their own cost through our trusted and vetted travel partners.</p>
                        <ul class="feature-list">
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Nairobi National Park:</strong> A half-day wildlife drive just 15 minutes from the city center.</li>
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Maasai Mara Escapes:</strong> 2-to-3 day luxury safari packages available at exclusive delegate rates.</li>
                            <li><svg class="icon-check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> <strong>Coastal Retreats:</strong> Direct flights to Mombasa and Diani Beach for post-summit relaxation.</li>
                        </ul>
                        <a href="contact" class="btn btn-outline" style="border-color: var(--primary-color); color: var(--primary-color); margin-top: 1rem;">Enquire About Tours &rarr;</a>
                    </div>
                    <div>
                        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2068&auto=format&fit=crop" alt="Safari Tour in Kenya" style="width: 100%; border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow);">
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
