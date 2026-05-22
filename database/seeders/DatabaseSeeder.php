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
                'content_en' => '12+ km Roads Completed',
                'content_gu' => '૧૨+ કિમી રસ્તા પૂર્ણ',
                'content_hi' => '12+ किमी सड़कें पूर्ण',
            ],
            [
                'key' => 'achievement_lights',
                'content_en' => '1,500+ LED Lights Installed',
                'content_gu' => '૧,૫૦૦+ એલઈડી લાઈટો સ્થાપિત',
                'content_hi' => '1,500+ एलईडी लाइटें स्थापित',
            ],
            [
                'key' => 'achievement_grievances',
                'content_en' => '98% Grievances Resolved',
                'content_gu' => '૯૮% ફરિયાદોનું નિરાકરણ',
                'content_hi' => '98% जनसमस्याओं का निवारण',
            ],
            [
                'key' => 'achievement_camps',
                'content_en' => '50+ Free Health Camps',
                'content_gu' => '૫૦+ મફત નિદાન કેમ્પ',
                'content_hi' => '50+ मुफ्त चिकित्सा शिविर',
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

        // 4. Approved Feedbacks Seeder
        Feedback::updateOrCreate(
            ['mobile_number' => '9876543210'],
            [
                'name' => 'Rajesh Patel',
                'area' => 'Gorwa',
                'title' => 'Excellent work on road repair',
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
                'title' => 'Safe street lights',
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
                'title' => 'Clean drinking water access',
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
                'title' => 'Garbage Collection Feedback',
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
                'title' => 'Tree Plantation Drive',
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
                'title' => 'Pothole repairs needed',
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
                'title' => 'Public Parks Maintenance',
                'message' => 'The local park is beautifully maintained with kids play area. Great place for morning walks.',
                'rating' => 4,
                'status' => 'approved',
                'is_featured' => false,
            ]
        );

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
    }
}
