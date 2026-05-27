<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CmsPage;
use App\Models\DevelopmentWork;
use App\Models\Feedback;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User Seeder (Strictly seeder only)
        User::updateOrCreate(
            ['email' => 'admin@sachinkhandelwal.com'],
            [
                'first_name' => 'Sachin',
                'last_name' => 'Khandelwal',
                'password' => Hash::make('Password@123'),
            ]
        );

        // 2. CMS Content Seeder
        $cmsData = [
            [
                'key' => 'hero_greeting',
                'content_en' => 'Namaste & Welcome',
                'content_gu' => 'નમસ્તે અને સ્વાગત છે',
                'content_hi' => 'नमस्ते और स्वागत है',
            ],
            [
                'key' => 'hero_title',
                'content_en' => 'Serving the People of Vadodara Ward No. 7',
                'content_gu' => 'વડોદરા વોર્ડ નં. ૭ ના જનતાની સેવામાં',
                'content_hi' => 'वडोदरा वार्ड नं. 7 की जनता की सेवा में',
            ],
            [
                'key' => 'hero_mission',
                'content_en' => 'Committed to development, public welfare, and transparent leadership.',
                'content_gu' => 'વિકાસ, લોક કલ્યાણ અને પારદર્શક નેતૃત્વ માટે પ્રતિબદ્ધ.',
                'content_hi' => 'विकास, लोक कल्याण और पारदर्शी नेतृत्व के लिए प्रतिबद्ध।',
            ],
            [
                'key' => 'about_title',
                'content_en' => 'Biography & Leadership Vision',
                'content_gu' => 'જીવનચરિત્ર અને નેતૃત્વ દ્રષ્ટિકોણ',
                'content_hi' => 'जीवनी और नेतृत्व दृष्टिकोण',
            ],
            [
                'key' => 'about_bio',
                'content_en' => 'Sachin Khandelwal is a dedicated public servant, Corporator of Vadodara Ward No. 7, and BJP Adhyaksh. With a deep sense of community service, he has led multiple infrastructure and public health campaigns to transform the ward.',
                'content_gu' => 'સચિન ખંડેલવાલ એક સમર્પિત લોકસેવક, વડોદરા વોર્ડ નં. ૭ ના કોર્પોરેટર અને ભાજપ અધ્યક્ષ છે. સામુદાયિક સેવાના ઊંડા દ્રષ્ટિકોણ સાથે, તેમણે વોર્ડના પરિવર્તન માટે અનેક માળખાકીય સુવિધાઓ અને જાહેર આરોગ્ય અભિયાનોનું નેતૃત્વ કર્યું છે.',
                'content_hi' => 'सचिन खंडेलवाल एक समर्पित लोक सेवक, वडोदरा वार्ड नं. 7 के कॉर्पोरेटर और भाजपा अध्यक्ष हैं। सामुदायिक सेवा की गहरी भावना के साथ, उन्होंने वार्ड के कायाकल्प के लिए कई बुनियादी ढांचे और सार्वजनिक स्वास्थ्य अभियानों का नेतृत्व किया है।',
            ],
            [
                'key' => 'about_vision',
                'content_en' => 'Our vision is to build a modern, clean, and self-reliant ward. We focus on continuous water supply, optimized road networks, women empowerment programs, and educational facilities.',
                'content_gu' => 'અમારો દ્રષ્ટિકોણ એક આધુનિક, સ્વચ્છ અને સ્વનિર્ભર વોર્ડ બનાવવાનો છે. અમે સતત પાણી પુરવઠો, શ્રેષ્ઠ રોડ નેટવર્ક, મહિલા સશક્તિકરણ કાર્યક્રમો અને શૈક્ષણિક સુવિધાઓ પર ધ્યાન કેન્દ્રિત કરીએ છીએ.',
                'content_hi' => 'हमारा दृष्टिकोण एक आधुनिक, स्वच्छ और आत्मनिर्भर वार्ड का निर्माण करना है। हम निरंतर जलापूर्ति, बेहतर सड़क नेटवर्क, महिला सशक्तिकरण कार्यक्रमों और शैक्षिक सुविधाओं पर ध्यान केंद्रित करते हैं।',
            ],
            [
                'key' => 'achievement_roads',
                'content_en' => '12 | + km | Roads Completed',
                'content_gu' => '12 | + કિમી | રસ્તા પૂર્ણ',
                'content_hi' => '12 | + किमी | सड़कें पूर्ण',
            ],
            [
                'key' => 'achievement_lights',
                'content_en' => '1500 | + | LED Lights Installed',
                'content_gu' => '1500 | + | એલઈડી લાઈટો સ્થાપિત',
                'content_hi' => '1500 | + | एलईडी लाइटें स्थापित',
            ],
            [
                'key' => 'achievement_grievances',
                'content_en' => '98 | % | Grievances Resolved',
                'content_gu' => '98 | % | ફરિયાદોનું નિરાકરણ',
                'content_hi' => '98 | % | जनसमस्याओं का निवारण',
            ],
            [
                'key' => 'achievement_camps',
                'content_en' => '50 | + | Free Health Camps',
                'content_gu' => '50 | + | મફત નિદાન કેમ્પ',
                'content_hi' => '50 | + | मुफ्त चिकित्सा शिविर',
            ],
        ];

        foreach ($cmsData as $data) {
            CmsPage::updateOrCreate(['key' => $data['key']], $data);
        }

        // 3. Development Works Seeder
        DevelopmentWork::updateOrCreate(
            ['title_en' => 'Premium Asphalt Road Laying'],
            [
                'title_gu' => 'પ્રીમિયમ ડામર રોડ કામગીરી',
                'title_hi' => 'प्रीमियम डामर सड़क निर्माण',
                'description_en' => 'Laying of durable, all-weather asphalt roads to connect local communities.',
                'description_gu' => 'સ્થાનિક સોસાયટીઓને જોડવા માટે ટકાઉ અને સર્વ-ઋતુ અનુકૂળ ડામર રોડનું નિર્માણ.',
                'description_hi' => 'स्थानीय सोसाइटियों को जोड़ने के लिए टिकाऊ और बारहमासी डामर सड़क का निर्माण।',
                'location' => 'VIP Road, Ward 7, Vadodara',
                'before_image' => 'images/before_road.jpg',
                'after_image' => 'images/after_road.jpg',
            ]
        );

        DevelopmentWork::updateOrCreate(
            ['title_en' => 'Smart Street Lighting'],
            [
                'title_gu' => 'એનર્જી-એફિશિયન્ટ એલઈડી સ્ટ્રીટલાઈટ સ્થાપન',
                'title_hi' => 'ऊर्जा-कुशल एलईडी स्ट्रीटलाइट स्थापना',
                'description_en' => 'Installed over 500 smart LED light systems to enhance safety and reduce power usage.',
                'description_gu' => 'સુરક્ષા વધારવા અને વીજળી બચાવવા માટે ૫૦૦ થી વધુ સ્માર્ટ એલઈડી લાઈટો લગાવવામાં આવી.',
                'description_hi' => 'सुरक्षा बढ़ाने और बिजली बचाने के लिए 500 से अधिक स्मार्ट एलईडी लाइटें लगाई गईं।',
                'location' => 'Subhanpura Area, Ward 7, Vadodara',
                'before_image' => 'images/before_light.jpg',
                'after_image' => 'images/after_light.jpg',
            ]
        );

        DevelopmentWork::updateOrCreate(
            ['title_en' => 'Clean Drinking Water Project'],
            [
                'title_gu' => 'નવી શુદ્ધ પીવાના પાણીની પાઇપલાઇન',
                'title_hi' => 'नई शुद्ध पेयजल पाइपलाइन',
                'description_en' => 'Replaced old pipelines with secure supply lines, ensuring pure drinking water access to 2,000+ households.',
                'description_gu' => '૨,૦૦૦ થી વધુ પરિવારોને શુદ્ધ પીવાનું પાણી મળે તે માટે જૂની પાઇપલાઇન બદલી નવી લાઇન નાખવામાં આવી.',
                'description_hi' => '2,000 से अधिक परिवारों को शुद्ध पेयजल सुनिश्चित करने के लिए पुरानी पाइपलाइनों को बदलकर नई लाइन डाली गई।',
                'location' => 'Gorwa Residential Zone, Ward 7, Vadodara',
                'before_image' => 'images/before_water.jpg',
                'after_image' => 'images/after_water.jpg',
            ]
        );

        // Generate 55 additional Development Works for testing pagination/filtering
        $devTitlesEn = [
            'Asphalt Road Resurfacing', 'LED Streetlight Installation', 'Drinking Water Pipeline Extension',
            'Community Park Development', 'Storm Water Drain Upgrade', 'Public Health Clinic Renovation',
            'Anganwadi Center Construction', 'Waste Segregation Station', 'CCTV Ward Security Network',
            'Smart Library and Study Room'
        ];
        $devTitlesGu = [
            'ડામર રોડ રિસર્ફેસિંગ કામગીરી', 'એલઈડી સ્ટ્રીટલાઇટ સ્થાપન', 'પીવાના પાણીની પાઇપલાઇન લંબાવવી',
            'સામુદાયિક બગીચાનો વિકાસ', 'વરસાદી પાણીની ગટર અપગ્રેડ', 'જાહેર આરોગ્ય કેન્દ્રનું નવીનીકરણ',
            'આંગણવાડી કેન્દ્રનું બાંધકામ', 'કચરો અલગ કરવાનું મથક', 'સીસીટીવી વોર્ડ સુરક્ષા નેટવર્ક',
            'સ્માર્ટ લાઇબ્રેરી અને અભ્યાસ ખંડ'
        ];
        $devTitlesHi = [
            'डामर सड़क रिसर्फेसिंग कार्य', 'एलईडी स्ट्रीटलाइट स्थापना', 'पेयजल पाइपलाइन विस्तार',
            'सामुदायिक पार्क विकास', 'बरसाती पानी नाला अपग्रेड', 'सार्वजनिक स्वास्थ्य केंद्र नवीनीकरण',
            'आंगनवाड़ी केंद्र निर्माण', 'कचरा पृथक्करण स्टेशन', 'सीसीटीवी वार्ड सुरक्षा नेटवर्क',
            'स्मार्ट लाइब्रेरी और अध्ययन कक्ष'
        ];

        $devDescEn = [
            'Upgraded the infrastructure to support modern traffic load and ensure all-weather transit.',
            'Installed energy-efficient illumination points across major intersections to prevent incidents.',
            'Laid high-density polyethylene supply lines to ensure clean potable water without contaminants.',
            'Created beautiful landscaping with walkways, benches, and play areas for the neighborhood.',
            'Reinforced underground concrete structures to withstand heavy monsoon rainfall events.',
            'Equipped the local wellness center with diagnostic equipment and primary medical aids.',
            'Built a child-friendly learning environment equipped with modular furniture and educational aids.',
            'Deployed automatic dry and wet segregation bins to enhance ward hygiene levels.',
            'Integrated high-definition thermal night-vision camera nodes connected to central monitoring.',
            'Configured digital computer systems and physical text catalogs for students and researchers.'
        ];
        $devDescGu = [
            'ટ્રાફિક લોડને ટેકો આપવા અને તમામ ઋતુમાં સરળ પરિવહન સુનિશ્ચિત કરવા માટે માળખાકીય સુવિધાઓ અપગ્રેડ કરી.',
            'અકસ્માતો અટકાવવા માટે મુખ્ય ચાર રસ્તાઓ પર ઊર્જા-કાર્યક્ષમ રોશની પોઇન્ટ સ્થાપિત કર્યા.',
            'શુદ્ધ પીવાનું પાણી ઉપલબ્ધ કરાવવા માટે હાઇ-ડેન્સિટી સપ્લાય લાઇન નાખવામાં આવી.',
            'રહીશો માટે વૉકવે, બેન્ચ અને રમતગમતના વિસ્તારો સાથે સુંદર બગીચો બનાવ્યો.',
            'ભારે ચોમાસાના વરસાદનો સામનો કરવા માટે ભૂગર્ભ કોંક્રિટ સ્ટ્રક્ચર્સને મજબૂત બનાવ્યા.',
            'સ્થાનિક આરોગ્ય કેન્દ્રને નિદાન સાધનો અને પ્રાથમિક તબીબી સહાયથી સજ્જ કર્યું.',
            'મોડ્યુલર ફર્નિચર અને શૈક્ષણિક સાધનોથી સજ્જ બાળ-સ્નેહી ભણતર વાતાવરણ બનાવ્યું.',
            'વોર્ડની સ્વચ્છતા સ્તર વધારવા માટે સ્વયંસંચાલિત સૂકા અને ભીના કચરાના ડબ્બા તૈનાત કર્યા.',
            'સેન્ટ્રલ મોનિટરિંગ સાથે જોડાયેલા હાઇ-ડેફિનેશન નાઇટ-વિઝન કેમેરા નોડ્સ સંકલિત કર્યા.',
            'વિદ્યાર્થીઓ અને સંશોધકો માટે ડિજિટલ કોમ્પ્યુટર સિસ્ટમ્સ અને પુસ્તકો ગોઠવ્યા.'
        ];
        $devDescHi = [
            'यातायात भार को संभालने और हर मौसम में सुगम पारगमन सुनिश्चित करने के लिए बुनियादी ढांचे को अपग्रेड किया।',
            'दुर्घटनाओं को रोकने के लिए प्रमुख चौराहों पर ऊर्जा-कुशल रोशनी वाले खंभे स्थापित किए गए।',
            'शुद्ध पेयजल सुनिश्चित करने के लिए उच्च घनत्व वाली सुरक्षित जल आपूर्ति लाइनें बिछाई गईं।',
            'निवासियों के लिए वॉकवे, बेंच और खेल क्षेत्रों के साथ सुंदर उद्यान का निर्माण किया।',
            'भारी मानसून बारिश का सामना करने के लिए भूमिगत कंक्रीट संरचनाओं को मजबूत किया गया।',
            'स्थानीय स्वास्थ्य केंद्र को नैदानिक ​​उपकरणों और प्राथमिक चिकित्सा सहायता से सुसज्जित किया।',
            'मॉड्यूलर फर्नीचर और शैक्षिक सहायता से सुसज्जित बाल-अनुकूल सीखने का माहौल बनाया।',
            'वार्ड की स्वच्छता बढ़ाने के लिए स्वचालित सूखे और गीले कचरे के डिब्बे तैनात किए गए।',
            'केंद्रीय निगरानी से जुड़े हाई-डेफिनिशन नाइट-विज़न कैमरा नोड्स को एकीकृत किया गया।',
            'छात्रों और शोधकर्ताओं के लिए डिजिटल कंप्यूटर सिस्टम और भौतिक पुस्तकों की व्यवस्था की।'
        ];

        $locations = [
            'Gorwa Main Road, Ward 7', 'Subhanpura Colony, Ward 7', 'VIP Avenue Crossroads, Ward 7',
            'Samta Residential Sector, Ward 7', 'Hari Nagar Market, Ward 7', 'Gotri Link Road, Ward 7'
        ];

        for ($i = 1; $i <= 55; $i++) {
            $idx = $i % 10;
            DevelopmentWork::updateOrCreate(
                ['title_en' => $devTitlesEn[$idx] . " (#$i)"],
                [
                    'title_gu' => $devTitlesGu[$idx] . " (#$i)",
                    'title_hi' => $devTitlesHi[$idx] . " (#$i)",
                    'description_en' => $devDescEn[$idx] . " This project serves thousands of residents directly.",
                    'description_gu' => $devDescGu[$idx] . " આ પ્રોજેક્ટ હજારો રહેવાસીઓને સીધો લાભ આપે છે.",
                    'description_hi' => $devDescHi[$idx] . " यह परियोजना सीधे हजारों निवासियों को लाभान्वित करती है।",
                    'location' => $locations[$i % count($locations)] . ", Vadodara",
                    'before_image' => 'images/before_road.jpg',
                    'after_image' => 'images/after_road.jpg',
                ]
            );
        }

        // 4. Approved Feedbacks Seeder
        Feedback::updateOrCreate(
            ['mobile_number' => '9876543210'],
            [
                'name' => 'Rajesh Patel',
                'area' => 'Gorwa',
                'message' => 'The new VIP road laying has resolved our traffic and monsoon flooding issues completely. Thank you Sachinbhai!',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9988776655'],
            [
                'name' => 'Meenaben Shah',
                'area' => 'Subhanpura',
                'message' => 'The new LED streetlights make walking late at night very safe for ladies and children. Great effort by our Corporator.',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9898989898'],
            [
                'name' => 'Amit Trivedi',
                'area' => 'VIP Road',
                'message' => 'Water pressure has improved and we now get clear, clean water without interruptions. Appreciate the swift action.',
                'rating' => 4,
                'status' => 'approved',
                'is_featured' => false,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9111111111'],
            [
                'name' => 'Vikram Rathore',
                'area' => 'Gorwa',
                'message' => 'Regular garbage collection van arrives on time every morning. Excellent hygienic initiative.',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9222222222'],
            [
                'name' => 'Sanjay Mehta',
                'area' => 'Subhanpura',
                'message' => 'Loved the new green canopy initiative in our area. Makes the environment fresh and clean.',
                'rating' => 5,
                'status' => 'pending',
                'is_featured' => false,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9333333333'],
            [
                'name' => 'Kirti Patel',
                'area' => 'VIP Road',
                'message' => 'A small pothole is developing near the main junction. Requesting prompt repairs before monsoons.',
                'rating' => 3,
                'status' => 'pending',
                'is_featured' => false,
            ]
        );

        Feedback::updateOrCreate(
            ['mobile_number' => '9444444444'],
            [
                'name' => 'Harish Shah',
                'area' => 'Gorwa',
                'message' => 'The local park is beautifully maintained with kids play area. Great place for morning walks.',
                'rating' => 4,
                'status' => 'approved',
                'is_featured' => false,
            ]
        );

        // Generate 55 additional mock feedback entries for testing pagination
        $names = [
            'Ramesh Patel', 'Geeta Shah', 'Sanjay Trivedi', 'Kishore Jani', 'Asha Mehta',
            'Vijay Parmar', 'Nisha Desai', 'Rajesh Joshi', 'Bina Vyas', 'Kamlesh Bhatia',
            'Sunita Sharma', 'Anil Vaghela', 'Rekha Dave', 'Manish Choksi', 'Kiran Soni',
            'Pravin Panchal', 'Daksha Darji', 'Dilip Modi', 'Hansa Solanki', 'Jayesh Rathod'
        ];
        
        $areas = ['Gorwa', 'Subhanpura', 'VIP Road', 'Samta', 'Hari Nagar', 'Gotri'];
        
        $messages = [
            'We are extremely satisfied with the swift road repair work done here. The corporator personally visited and resolved our query within days.',
            'The daily morning drinking water pressure has improved significantly. We get pure water without any issues. Thank you so much!',
            'New high-lumen streetlights have made our society street look safe and beautiful at night. Kids and elderly can now walk safely.',
            'Great initiative by Sachinbhai for conducting the clean drive campaign. The local municipality cleaning vans are arriving on time.',
            'Highly appreciate the medical and dental camps organized in our neighborhood. Got free diagnosis and free medicine packets.',
            'The kids park has beautiful swings and green turf. Our evenings are spent happily there. Excellent infrastructural design.',
            'The drainage issue near Gorwa circle has been resolved by installing wider storm lines. No water logging this year!',
            'Thank you for standing up for ward security and community support. The ward looks clean, green, and highly prosperous.'
        ];

        for ($i = 1; $i <= 55; $i++) {
            $mobile = '90000' . str_pad($i, 5, '0', STR_PAD_LEFT);
            Feedback::updateOrCreate(
                ['mobile_number' => $mobile],
                [
                    'name' => $names[($i % count($names))] . ' ' . chr(65 + ($i % 26)),
                    'area' => $areas[($i % count($areas))],
                    'message' => $messages[($i % count($messages))] . " We truly appreciate the continuous support from the corporator team.",
                    'rating' => ($i % 3 === 0) ? 4 : 5,
                    'status' => ($i % 10 === 0) ? 'pending' : (($i % 15 === 0) ? 'rejected' : 'approved'),
                    'is_featured' => ($i % 12 === 0),
                ]
            );
        }

        // 5. Settings Seeder
        Setting::updateOrCreate(
            ['key' => 'office_address'],
            ['value' => 'GF-4, Ward Office Building, Subhanpura Road, Vadodara, Gujarat - 390023']
        );
        Setting::updateOrCreate(
            ['key' => 'office_phone'],
            ['value' => '+91 265 2390777']
        );
        Setting::updateOrCreate(
            ['key' => 'office_email'],
            ['value' => 'office@sachinkhandelwal.com']
        );
        Setting::updateOrCreate(
            ['key' => 'office_timings'],
            ['value' => 'Monday - Saturday: 10:00 AM - 06:00 PM']
        );

        // 6. Gallery Images Seeder
        $galleryData = [
            [
                'image_path' => 'images/gallery_visit1.jpg',
                'category' => 'visits',
                'caption_en' => 'Ward inspection with senior engineers.',
                'caption_gu' => 'વરિષ્ઠ ઈજનેરો સાથે વોર્ડ નિરીક્ષણ.',
                'caption_hi' => 'वरिष्ठ इंजीनियरों के साथ वार्ड निरीक्षण।'
            ],
            [
                'image_path' => 'images/gallery_event1.jpg',
                'category' => 'events',
                'caption_en' => 'BJP party meeting in Subhanpura.',
                'caption_gu' => 'સુભાનપુરામાં ભાજપ પક્ષની બેઠક.',
                'caption_hi' => 'सुभानपुरा में भाजपा पार्टी की बैठक।'
            ],
            [
                'image_path' => 'images/gallery_work1.jpg',
                'category' => 'works',
                'caption_en' => 'New asphalt laying execution.',
                'caption_gu' => 'નવા ડામર રોડની કામગીરી.',
                'caption_hi' => 'नया डामर सड़क निर्माण कार्य।'
            ],
            [
                'image_path' => 'images/gallery_community1.jpg',
                'category' => 'community',
                'caption_en' => 'Free health checkup camp.',
                'caption_gu' => 'નિઃશુલ્ક નિદાન અને સારવાર કેમ્પ.',
                'caption_hi' => 'निःशुल्क चिकित्सा एवं जांच शिविर।'
            ],
            [
                'image_path' => 'images/gallery_visit2.jpg',
                'category' => 'visits',
                'caption_en' => 'Meeting residents of VIP Road.',
                'caption_gu' => 'વીઆઈપી રોડના રહીશો સાથે મુલાકાત.',
                'caption_hi' => 'वीआईपी रोड के निवासियों के साथ बैठक।'
            ],
            [
                'image_path' => 'images/gallery_community2.jpg',
                'category' => 'community',
                'caption_en' => 'Women empowerment workshop.',
                'caption_gu' => 'મહિલા સશક્તિકરણ કાર્યશાળા.',
                'caption_hi' => 'महिला सशक्तिकरण कार्यशाला।'
            ]
        ];

        foreach ($galleryData as $g) {
            \App\Models\GalleryImage::updateOrCreate(['image_path' => $g['image_path']], $g);
        }

        // Generate 55 additional Gallery Images for testing gallery filtering/pagination
        $categories = ['visits', 'events', 'works', 'community'];
        $captionsEn = [
            'Inspecting new water purification facility with citizens.', 'Inaugurating the digital smart library block.',
            'Reviewing local sewage lines before monsoon season.', 'Greeting the children at the local Anganwadi.',
            'Distributing health kits at the free diagnostic camp.', 'Discussing community issues during corner meetings.',
            'Monitoring the smart LED streetlight implementation.', 'Participating in the annual tree plantation drive.',
            'Addressing public grievances during open-house ward meet.', 'Felicitating brilliant ward scholars at school event.'
        ];
        $captionsGu = [
            'નાગરિકો સાથે નવી પાણી શુદ્ધિકરણ સુવિધાનું નિરીક્ષણ.', 'ડિજિટલ સ્માર્ટ લાઇબ્રેરી બ્લોકનું ઉદ્ઘાટન.',
            'ચોમાસા પહેલા સ્થાનિક ગટર લાઇનની સમીક્ષા.', 'સ્થાનિક આંગણવાડીમાં બાળકોનું સ્વાગત.',
            'મફત નિદાન કેમ્પમાં હેલ્થ કીટનું વિતરણ.', 'વોર્ડ બેઠકો દરમિયાન સામુદાયિક પ્રશ્નોની ચર્ચા.',
            'સ્માર્ટ એલઈડી સ્ટ્રીટલાઇટ કામગીરીનું નિરીક્ષણ.', 'વાર્ષિક વૃક્ષારોપણ અભિયાનમાં સહભાગી થવું.',
            'જાહેર રજૂઆતો દરમિયાન જન સમસ્યાઓનું સાંભળવું.', 'શાળાના કાર્યક્રમમાં તેજસ્વી વિદ્યાર્થીઓનું સન્માન.'
        ];
        $captionsHi = [
            'नागरिकों के साथ नई जल शोधन सुविधा का निरीक्षण।', 'डिजिटल स्मार्ट लाइब्रेरी ब्लॉक का उद्घाटन।',
            'मानसून से पहले स्थानीय सीवेज लाइनों की समीक्षा।', 'स्थानीय आंगनवाड़ी में बच्चों का स्वागत।',
            'निःशुल्क चिकित्सा शिविर में स्वास्थ्य किट का वितरण।', 'वार्ड बैठकों के दौरान सामुदायिक मुद्दों पर चर्चा।',
            'स्मार्ट एलईडी स्ट्रीटलाइट कार्य का निरीक्षण।', 'वार्षिक वृक्षारोपण अभियान में भागीदारी।',
            'खुली जनसुनवाई के दौरान नागरिक समस्याओं का निवारण।', 'स्कूल के कार्यक्रम में मेधावी छात्रों का सम्मान।'
        ];

        for ($i = 1; $i <= 55; $i++) {
            $idx = $i % 10;
            \App\Models\GalleryImage::updateOrCreate(
                ['image_path' => "images/gallery_item_" . $i . ".jpg"],
                [
                    'category' => $categories[$i % count($categories)],
                    'caption_en' => $captionsEn[$idx] . " (#$i)",
                    'caption_gu' => $captionsGu[$idx] . " (#$i)",
                    'caption_hi' => $captionsHi[$idx] . " (#$i)",
                ]
            );
        }
    }
}
