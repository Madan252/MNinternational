// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {

    // ====== PRODUCTS DATA WITH CORRECT IMAGE PATHS ======
    const productsData = [
        // Analog Cameras
        { id: 1, name: "DS-2CE10DF0T-PF", category: "analog-cam", short: "2 MP HD ColorVU Outdoor Bullet", fullDesc: "IP67, full time color, 1080p@25/30fps, 3D DNR, OSD menu, white-light up to 20m.", price: 4194, image: "image/analog-cam/DS-2CE10DF0T-PFanalog.jpg" },
        { id: 2, name: "DS-2CE11HOT-PIRL", category: "analog-cam", short: "5 MP HD Outdoor Bullet PIR", fullDesc: "5MP resolution, PIR detection, up to 20m IR distance, IP67, 3.6mm lens.", price: 4667, image: "image/analog-cam/DS-2CE11HOT-PIRLanalog.jpg" },
        { id: 3, name: "DS-2CE16D0T-EXIPF", category: "analog-cam", short: "2 MP HD IR Outdoor Bullet", fullDesc: "2MP CMOS, 12pcs LEDs, 3.6mm Lens, upto 20m IR, IP66, 1080p@25fps.", price: 2607, image: "image/analog-cam/DS-2CE16D0T-EXIPFanalog.jpg" },
        { id: 4, name: "DS-2CE16D0T-EXLPF", category: "analog-cam", short: "2 MP Smart Hybrid Bullet", fullDesc: "Smart-Hybrid light, 1920×1080 resolution, 2.8/3.6mm lens, 20m IR distance.", price: 2696, image: "image/analog-cam/DS-2CE16D0T-EXLPFanalog.jpg" },
        { id: 5, name: "DS-2CE16D0T-ITPFS", category: "analog-cam", short: "2 MP HD IR Outdoor Audio Bullet", fullDesc: "2MP CMOS, 2.8/3.6/6mm lens, upto 25m IR, Smart IR, DWDR, DNR, 1080p@30fps.", price: 3120, image: "image/analog-cam/DS-2CE16D0T-ITPFSanalog.jpeg" },
        { id: 6, name: "DS-2CE16D0T-LPFS", category: "analog-cam", short: "2 MP IR Smart Light Audio Bullet", fullDesc: "1920x1080, Pan 0-360°, Tilt 0-180°, IP67, IR up to 25m, White Light up to 20m.", price: 3100, image: "image/analog-cam/DS-2CE16D0T-LPFSanalog.jpg" },
        { id: 7, name: "DS-2CE16H0T-ITPF", category: "analog-cam", short: "5 MP Fixed Mini Bullet", fullDesc: "5MP, Smart IR up to 25m, IP67, 4in1 video output, 2.8/3.6/6mm lens.", price: 4160, image: "image/analog-cam/DS-2CE16H0T-ITPFanalog.jpeg" },
        { id: 8, name: "DS-2CE70DF0T-PF", category: "analog-cam", short: "2 MP HD ColorVU Indoor Bullet", fullDesc: "Full time color, 2MP CMOS, 0.001lux/F1.0, white-light upto 20m, True DWDR.", price: 4057, image: "image/analog-cam/DS-2CE70DF0T-PFanalog.jpeg" },
        { id: 9, name: "DS-2CE76D0T-EXLPF", category: "analog-cam", short: "2 MP Smart Hybrid Indoor Dome", fullDesc: "1920×1080 resolution, 2.8 mm / 3.6 mm fixed lens, 20 m IR distance, TVI/AHD/CVI/CVBS.", price: 2426, image: "image/analog-cam/DS-2CE76D0T-EXLPF analog.jpg" },
        { id: 10, name: "DS-2CE76D0T-LPFS", category: "analog-cam", short: "2 MP IR Smart Light Audio Camera", fullDesc: "Indoor dome, 20m IR, TVI/AHD/CVI/CVBS, Digital WDR, audio support, 2.8/3.6mm lens.", price: 2859, image: "image/analog-cam/DS-2CE76D0T-LPFSanalog.jpeg" },
        { id: 11, name: "DS-2CE76H0T-ITPF", category: "analog-cam", short: "5 MP Indoor Fixed Turret", fullDesc: "5 MP, 2560×1944, Digital WDR, Smart IR up to 20m, 4in1 video output.", price: 4160, image: "image/analog-cam/DS-2CE76H0T-ITPFanalog.jpeg" },
        
        // DVR-NVR-EDVR
       { id: 12, name: "DS-7104HGHI-M1", category: "dvr-nvr", price: 6500, short: "4-Channel DVR", fullDesc: "H.265 Pro+, 4-ch analog, 1 SATA up to 4TB, support 1080p lite.", image: "image/DVR _NVR _eDVR/DS-7104HGHI-M1dvr.jpeg" },
        { id: 13, name: "DS-7108HGHI-M1", category: "dvr-nvr", price: 8500, short: "8-Channel DVR", fullDesc: "8-ch analog, 1 SATA up to 4TB, motion detection 2.0, H.265 compression.", image: "image/DVR _NVR _eDVR/DS-7108HGHI-M1dvr.jpeg" },
        { id: 14, name: "DS-7116HGHI-K1", category: "dvr-nvr", price: 15000, short: "16-Channel DVR", fullDesc: "16-ch analog, 1 SATA up to 10TB, Hik-Connect, support 1080p lite.", image: "image/DVR _NVR _eDVR/DS-7116HGHI-K1dvr.jpeg" },
        { id: 15, name: "DS-7104HQHI-K1", category: "dvr-nvr", price: 9142, short: "4-Ch DVR (5MP Support)", fullDesc: "H.265 Pro+, up to 6TB per HDD, Hik-Connect, 3rd party cloud.", image: "image/DVR _NVR _eDVR/DS-7104HQHI-K1dvr.jpg" },
        { id: 16, name: "DS-7108HQHI-K1", category: "dvr-nvr", price: 14321, short: "8-Ch DVR (5MP Support)", fullDesc: "Max 800m for 1080p HDTVI, Hik-Connect, up to 6TB HDD.", image: "image/DVR _NVR _eDVR/DS-7108HQHI-K1dvr.jpg" },
        { id: 17, name: "iDS-7116HQHI-M1/S", category: "dvr-nvr", price: 24505, short: "16-ch AcuSense DVR", fullDesc: "H.265 Pro+, up to 10TB per HDD, HDTVI/AHD/CVI/CVBS/IP video input.", image: "image/DVR _NVR _eDVR/iDS-7116HQHI-M1Sdvr.jpeg" },
        { id: 18, name: "DS-E04HGHI-B", category: "dvr-nvr", price: 11552, short: "HD1080P Lite 4Ch eDVR", fullDesc: "eSSD built-in 512GB, Motion Detection 2.0, up to 4MP Lite encoding.", image: "image/DVR _NVR _eDVR/DS-E04HGHI-Bedvr.jpeg" },
        { id: 19, name: "DS-E04HQHI-B", category: "dvr-nvr", price: 14651, short: "5 MP Lite 4Ch eDVR", fullDesc: "eSSD technology, deep learning perimeter protection, up to 3K/5MP Lite@12fps.", image: "image/DVR _NVR _eDVR/DS-E04HQHI-Bedvr.jpeg" },
        { id: 20, name: "DS-7608NI-Q1", category: "dvr-nvr", price: 9900, short: "8 Channel NVR", fullDesc: "H.265+, up to 60Mbps, 1 SATA up to 6TB, 4MP playback.", image: "image/DVR _NVR _eDVR/DS-7608NI-Q1nvr.webp" },
        { id: 21, name: "DS-7616NI-K2", category: "dvr-nvr", price: 27000, short: "16-ch 4K NVR", fullDesc: "2 SATA interfaces, facial recognition, perimeter protection, H.265+.", image: "image/DVR _NVR _eDVR/DS-7616NI-K2nvr.jpeg" },
        
     
    // ========== IP CAMERAS ==========
        { id: 22, name: "DS-2CD1323G0E-I", category: "ip-cam", price: 6000, short: "2 MP IR IP Indoor Dome", fullDesc: "1/2.7\" CMOS, H.265+, 30m IR, DWDR, IP67, Smart IR, 2.8mm lens, 1920x1080.", image: "image/ip-cam/DS-2CD1323G0E-Iipcam.jpg" },
        { id: 23, name: "DS-2CD1023G0E-I", category: "ip-cam", price: 6000, short: "2 MP IR IP Bullet Outdoor", fullDesc: "4mm lens, IR 30m, Smart IR, IP67, 3DNR, ONVIF, H.265+.", image: "image/ip-cam/DS-2CD1023G0E-Iipcam.jpg" },
        { id: 24, name: "DS-2CD12T23G2-I", category: "ip-cam", price: 7000, short: "2 MP IP Bullet (Human/Vehicle)", fullDesc: "Human & Vehicle Detection, IP67, EXIR 2.0, H.265+, built-in mic optional.", image: "image/ip-cam/DS-2CD12T23G2-Iipcam.jpg" },
        { id: 25, name: "DS-2CD14T43G2-I", category: "ip-cam", price: 8874, short: "4 MP IP Outdoor Bullet", fullDesc: "4MP resolution, Human/Vehicle Detection, H.265+, EXIR 2.0, SD card slot.", image: "image/ip-cam/DS-2CD14T43G2-Iipcam.jpeg" },
        { id: 26, name: "DS-2CD22T23G2-2I", category: "ip-cam", price: 12750, short: "2 MP AccuSense Fixed Bullet", fullDesc: "Deep learning classification, 120dB WDR, IP67, H.265+ efficient.", image: "image/ip-cam/DS-2CD22T23G2-2Iipcam.jpg" },
        { id: 27, name: "DS-2CD20G3G2-I", category: "ip-cam", price: 15270, short: "6 MP AccuSense Fixed Bullet", fullDesc: "6MP, WDR 120dB, human/vehicle, built-in mic, IP67.", image: "image/ip-cam/DS-2CD20G3G2-Iipcam.jpg" },
        { id: 28, name: "DS-2CD1323G2-LIU", category: "ip-cam", price: 6800, short: "2 MP IR IP Audio Dome", fullDesc: "Hybrid light, IR+White, Motion Detection 2.0, built-in audio, IP67.", image: "image/ip-cam/DS-2CD1323G2-LIUipcam.jpg" },
        { id: 29, name: "DS-2CD1023G2-LIU", category: "ip-cam", price: 6800, short: "2 MP Smart Hybrid Light Bullet", fullDesc: "IR and White Light, up to 30m supplement, built-in mic, H.265+.", image: "image/ip-cam/DS-2CD1023G2-LIUipcam.jpeg" },
        { id: 30, name: "DS-2CD1043G2-LIU", category: "ip-cam", price: 10000, short: "4 MP Smart Hybrid Light Bullet", fullDesc: "4MP, H.265+, motion detection 2.0, SD card support, IP67.", image: "image/ip-cam/DS-2CD1043G2-LIUipcam.jpeg" },
        { id: 31, name: "DS-2CD1127G2-LIU", category: "ip-cam", price: 8881, short: "2 MP ColorVu VandalProof", fullDesc: "Smart Hybrid Light, Human/Vehicle detection, IP67 & IK08, built-in mic.", image: "image/ip-cam/DS-2CD1127G2-LIUipcam.jpg" },
        { id: 32, name: "DS-2CD2T27G2-L", category: "ip-cam", price: 17950, short: "2 MP ColorVu Fixed Bullet", fullDesc: "24/7 colorful imaging, 120dB WDR, deep learning, IP67.", image: "image/ip-cam/DS-2CD2T27G2-Lipcam.jpeg" },
        { id: 33, name: "DS-2CD2T87G3-LIU", category: "ip-cam", price: 36484, short: "8 MP ColorVu Bullet", fullDesc: "1/1.8\" CMOS, 2688x1520, 60m white light, 130dB WDR, H.265+.", image: "image/ip-cam/DS-2CD2T87G3-LIUipcam.jpeg" },
        { id: 34, name: "DS-2DE4215W", category: "ip-cam", price: 42494, short: "4-inch 2MP 15X Speed Dome", fullDesc: "DarkFighter IR, 15x optical zoom, intrusion detection, IP66, H.265+.", image: "image/ip-cam/DS-2DE4215Wipcam.jpeg" },
        { id: 35, name: "DS-2DE4425W", category: "ip-cam", price: 62118, short: "4MP 25X PTZ IR Speed Dome", fullDesc: "4MP 25x optical, WDR 120dB, 100m IR, line crossing detection.", image: "image/ip-cam/DS-2DE4425Wipcam.jpg" },
 // ========== EZVIZ ==========
      
    { id: 36, name: "EZVIZ C83 Solar Bundle", category: "ezviz", price: 14136, short: "Battery Solar Camera", fullDesc: "1000p resolution, Color Night Vision, Two-Way Talk, up to 120 days battery, active defense siren.", image: "image/Eizviz/EZVIZ C83SolarBundle.jpeg" },
    { id: 37, name: "EZVIZ BM1", category: "ezviz", price: 14863, short: "1000p Battery Camera", fullDesc: "AI human detection, crying detection, auto-pay, soothing music, clear night vision, 2000mAh.", image: "image/Eizviz/EZVIZ BM1.jpg" },
    { id: 38, name: "EZVIZ BC2", category: "ezviz", price: 13361, short: "1000p Smart Battery Cam", fullDesc: "Night vision up to 5m, two-way talk, up to 50 days, Google Assistant integration.", image: "image/Eizviz/EZVIZ BC2.jpg" },
    { id: 39, name: "EZVIZ CBB (IMP)", category: "ezviz", price: 20270, short: "2K Panoramic Battery", fullDesc: "300° coverage, up to 210 days battery, auto-tracking, color night vision, weatherproof.", image: "image/Eizviz/EZVIZ CBB (IMP).jpg" },
    { id: 40, name: "EZVIZ EBB (4G)", category: "ezviz", price: 24866, short: "4G Battery Camera", fullDesc: "2K resolution, 10400mAh battery, GPS location, two-way talk, siren & strike light.", image: "image/Eizviz/EZVIZ EBB (4G).png" },
    { id: 41, name: "EZVIZ HBB (IMP)", category: "ezviz", price: 22270, short: "2K Battery Cam + 32GB eMMC", fullDesc: "210 days battery life, color night vision, free built-in storage, solar panel compatible.", image: "image/Eizviz/EZVIZ HBB (IMP).jpg" },
    { id: 42, name: "EZVIZ HS (POE)", category: "ezviz", price: 6540, short: "2K POE Camera", fullDesc: "Power over Ethernet, color night vision, IP67, AI human/vehicle detection.", image: "image/Eizviz/EZVIZ HS (POE).png" },
    { id: 43, name: "EZVIZ XSS 8W NVR", category: "ezviz", price: 8916, short: "Supports 4K NVR", fullDesc: "8-channel NVR, 4K HDMI output, easy IP management, H.265 compression.", image: "image/Eizviz/EZVIZ XSS 8W NVR.jpg" },
    
       // ========== ACCESS CONTROL ==========
    { id: 44, name: "Doorbell HPT", category: "access", price: 25266, short: "2K Wi-Fi Video Doorbell", fullDesc: "7-inch color touch screen, remote unlock, 2-wire, two-way talk, MicroSD up to 512GB.", image: "image/accesscontrol/Doorbell HPT.jpg" },
    { id: 45, name: "DL65 Smart Lock", category: "access", price: 19428, short: "Smart Lock with Doorbell", fullDesc: "Multiple unlock methods, built-in electronic doorbell, weatherproof, low-battery warning.", image: "image/accesscontrol/DL65 Smart Lock.jpg" },
    { id: 46, name: "DS-K1A8503EF-B", category: "access", price: 9500, short: "Fingerprint Time Attendance", fullDesc: "2.4-inch LCD, TCP/IP, 1000 users, 1000 fingerprints, 100k events.", image: "image/accesscontrol/DS-K1A8503EF-B.jpg" },
    { id: 47, name: "DS-KAS261", category: "access", price: 17250, short: "Fingerprint Terminal Kit", fullDesc: "Kit includes terminal, magnetic lock, bracket, push button.", image: "image/accesscontrol/DS-KAS261.jpg" },
    { id: 48, name: "DS-KAS541", category: "access", price: 35500, short: "Face Recognition Terminal Kit", fullDesc: "Deep learning face, 4.3\" touch screen, multiple auth modes, IP65.", image: "image/accesscontrol/DS-KAS541.jpg" },
    { id: 49, name: "DS-K1T320MFWX", category: "access", price: 15000, short: "Value Series Face Terminal", fullDesc: "2.4\" screen, face/fingerprint/card, 500 faces, web client config.", image: "image/accesscontrol/DS-K1T320MFWX.png" },
    { id: 50, name: "DS-K1T341AMF", category: "access", price: 27781, short: "Face Access Terminal", fullDesc: "Mask wearing alert, 3000 faces, 4.3\" touch, wide-angle lens.", image: "image/accesscontrol/DS-K1T341AMF.jpg" },
    { id: 51, name: "DS-KIS605", category: "access", price: 22330, short: "Villa IP Video Intercom Kit", fullDesc: "IP video intercom, one call button, includes indoor station and PSU.", image: "image/accesscontrol/DS-KIS605.jpeg" },

    // ========== CABLES & POWER SUPPLY ==========
{ id: 52, name: "DS-1LN60UTPE", category: "accessories", price: 24755, short: "CAT6 Outdoor Cable 305m", fullDesc: "24AWG pure copper, 100% copper, PoE performance, Fluke tested.", image: "image/accessories/DS-1LN60UTPE.jpg" },
{ id: 53, name: "DS-1LN5E0-UU/E", category: "accessories", price: 20883, short: "CAT5E UTP Outdoor", fullDesc: "Solid copper, 0.5mm core, excellent transmission, PVC flame resistance.", image: "image/accessories/DS-1LN5E0-UUE.jpeg" },
{ id: 54, name: "DS-2FA1205-DW-IN", category: "accessories", price: 1231, short: "12V/5A SMPS", fullDesc: "Metal housing, power supply for cameras, 200-240VAC input.", image: "image/accessories/DS-2FA1205-DW-IN.jpg" },
{ id: 55, name: "DS-2FA120A-DW-IN", category: "accessories", price: 1720, short: "12V/10A SMPS", fullDesc: "10A max output, metal case, robust for multi-camera.", image: "image/accessories/DS-2FA120A-DW-IN.jpg" },
{ id: 56, name: "DS-2FA120K-DW-IN", category: "accessories", price: 2700, short: "12V/20A SMPS", fullDesc: "High power 20A, suitable for large installations.", image: "image/accessories/DS-2FA120K-DW-IN.jpeg" },
{ id: 57, name: "DS-1LH1SCAM592C", category: "accessories", price: 4379, short: "2+1 Coaxial CCTV Cable 90m", fullDesc: "OFC conductor, CCA braiding, anti-interference.", image: "image/accessories/DS-1LH1SCAM592C.jpeg" }
    ];
  
    // ====== HELPER FUNCTIONS ======
    function renderProducts(categoryFilter) {
        const container = document.getElementById('productsContainer');
        if (!container) return;

        let filtered = categoryFilter === 'all'
            ? [...productsData]
            : productsData.filter(p => p.category === categoryFilter);

        if (filtered.length === 0) {
            container.innerHTML = `<div class="no-results">📭 No products in this category. Try another tab!</div>`;
            return;
        }

        container.innerHTML = '';

        filtered.forEach(product => {
            const card = document.createElement('div');
            card.className = 'product-card';

            let catLabel = '';
            if (product.category === 'analog-cam') catLabel = '📹 Analog Camera';
            else if (product.category === 'ip-cam') catLabel = '🌐 IP Camera';
            else if (product.category === 'dvr-nvr') catLabel = '💾 Recorder';
            else if (product.category === 'ezviz') catLabel = '🔋 EZVIZ';
            else if (product.category === 'access') catLabel = '🔑 Access Control';
            else if (product.category === 'accessories') catLabel = '🔌 Accessory';

            const cardContent = `
                <div class="card-image">
                    <img src="${product.image}" 
                         alt="${product.name}" 
                         class="product-img"
                         onerror="this.src='https://placehold.co/600x400/1a1c31/white?text=${encodeURIComponent(product.name)}'">
                </div>
                <div class="card-content">
                    <span class="badge-category">${catLabel}</span>
                    <div class="model-name">${escapeHtml(product.name)}</div>
                    <div class="sku">SKU: ${product.id}</div>
                    <div class="price">Rs. ${product.price.toLocaleString()}</div>
                    <div class="short-desc">${escapeHtml(product.short)}</div>
                    <button class="see-more-btn" data-id="${product.id}">🔍 See More details</button>
                </div>
                <div class="full-description" id="desc-${product.id}">
                    <strong>📄 Full Specification:</strong><br>${escapeHtml(product.fullDesc)}
                </div>
            `;

            card.innerHTML = cardContent;
            container.appendChild(card);
        });

        // Toggle full description
        document.querySelectorAll('.see-more-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const productId = btn.getAttribute('data-id');
                const descDiv = document.getElementById(`desc-${productId}`);
                if (descDiv) {
                    descDiv.classList.toggle('show');
                    btn.innerHTML = descDiv.classList.contains('show') ? '📖 Show less' : '🔍 See More details';
                }
            });
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
            return c;
        });
    }

    // ====== TABS LOGIC ======
    function initTabs() {
        const tabs = document.querySelectorAll('.tab-btn');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const cat = tab.getAttribute('data-cat');

                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                renderProducts(cat);
            });
        });
    }

    // ====== INIT ======
    renderProducts('all'); // Show all by default
    initTabs();
});