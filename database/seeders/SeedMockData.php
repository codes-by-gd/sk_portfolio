<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Complaint;
use App\Models\ProjectTimeline;
use App\Models\ProjectMilestone;

class SeedMockData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure database has some mock contacts
        if (Contact::count() === 0) {
            Contact::create([
                'first_name' => 'Amit',
                'last_name' => 'Patel',
                'mobile_number' => '+91 98980 12345',
                'email' => 'amit.patel@ahmedabad.gov.in',
                'designation' => 'Chief Ward Executive (Ward 4)',
                'address' => 'Municipal Office, Gandhi Chowk, Ahmedabad, Gujarat',
                'notes' => 'Primary contact for Ward 4 municipal works and drainage layouts. Available 10 AM to 6 PM.',
            ]);

            Contact::create([
                'first_name' => 'Sanjay',
                'last_name' => 'Sharma',
                'mobile_number' => '+91 94250 56789',
                'email' => 'sanjay.sharma@pwd.gov.in',
                'designation' => 'Executive Road Engineer',
                'address' => 'PWD Circle Office, Cantonment Area',
                'notes' => 'Manages highway connectivity, bypass flyover schedules and hotmix approvals.',
            ]);

            Contact::create([
                'first_name' => 'નરેન્દ્ર',
                'last_name' => 'ત્રિવેદી',
                'mobile_number' => '+91 99044 11223',
                'email' => 'narendra.trivedi@ward4.org',
                'designation' => 'કોમ્યુનિટી હેડ (Community Head)',
                'address' => 'સેક્ટર ૨, શ્રીજી પાર્ક સોસાયટી',
                'notes' => 'સ્થાનિક સરકારી યોજનાઓ અને સામાજિક કલ્યાણ પ્રવૃત્તિઓ માટે સંપર્ક કરવો.',
            ]);
        }

        // Ensure database has some mock complaints
        if (Complaint::count() === 0) {
            Complaint::create([
                'complainant_name' => 'Ramesh Mehta',
                'complainant_mobile' => '+91 98250 88888',
                'area' => 'Ward 4 (Gandhi Chowk)',
                'category' => 'water',
                'description' => 'પીવાના પાણીની મુખ્ય પાઇપલાઇનમાં લીકેજ હોવાને કારણે છેલ્લા ૪ દિવસથી પાણીનો બગાડ થઈ રહ્યો છે અને પ્રેશર ઓછું આવે છે. (Drinking water main pipeline leakage causing water wastage and low pressure for 4 days.)',
                'status' => 'pending',
            ]);

            Complaint::create([
                'complainant_name' => 'Vikram Singh',
                'complainant_mobile' => '+91 99799 44444',
                'area' => 'Subhash Marg Junction',
                'category' => 'street_light',
                'description' => 'Subhash Marg corner street lights (3 lamps) are continuously blinking or completely shut off, causing safety concerns for women and elderly in evening hours.',
                'status' => 'under_review',
                'official_action' => 'Site inspection assigned to Electrical Maintenance Team. Spare bulb order issued.',
            ]);

            Complaint::create([
                'complainant_name' => 'Sunita Ben',
                'complainant_mobile' => '+91 90123 45678',
                'area' => 'Vikas Nagar Ward 8',
                'category' => 'sanitation',
                'description' => 'Open garbage pile and sewage backup at the entrance block of Vikas Nagar causing strong odor and hygiene risks.',
                'status' => 'resolved',
                'official_action' => 'Sanitation crew dispatched. Cleaned the entry block, added bleaching powder, and sewage block cleared.',
            ]);
        }

        // Ensure database has some mock timelines
        if (ProjectTimeline::count() === 0) {
            $project1 = ProjectTimeline::create([
                'project_name' => 'Ward 4 Drinking Water Pipeline & Filter Plant',
                'location' => 'Gandhi Chowk Substation',
                'budget' => 2850000.00,
                'start_date' => '2026-06-01',
                'target_completion' => '2026-09-30',
                'current_phase' => 'Trench Clearing & Pipe Laying',
                'status' => 'active',
                'notes' => 'Provides clean drinking water to over 15,000 residents across Gandhi Chowk and Hariom Nagar.',
            ]);

            $project1->milestones()->create([
                'title' => 'Geological Site Survey & Clearances',
                'description' => 'Soil testing completed and structural safety approvals received from Municipal Board.',
                'status' => 'completed',
                'milestone_date' => '2026-06-05',
            ]);

            $project1->milestones()->create([
                'title' => 'Procurement of High-Density Polyethylene (HDPE) Pipes',
                'description' => 'Ordered pipes delivered to municipal stockyard.',
                'status' => 'completed',
                'milestone_date' => '2026-06-12',
            ]);

            $project1->milestones()->create([
                'title' => 'Trench Excavation and Bedding Preparation',
                'description' => 'Digging along Gandhi Chowk main road up to 1.5 meters depth.',
                'status' => 'pending',
                'milestone_date' => '2026-07-15',
            ]);

            $project2 = ProjectTimeline::create([
                'project_name' => 'Smart Street LED Installation Program',
                'location' => 'All Ward Sectors (1 to 10)',
                'budget' => 1250000.00,
                'start_date' => '2026-05-10',
                'target_completion' => '2026-07-20',
                'current_phase' => 'Phase 1 Complete, Phase 2 Fixture Fitting',
                'status' => 'active',
                'notes' => 'Energy efficient auto-dimming LED replacements under Smart City Initiatives.',
            ]);

            $project2->milestones()->create([
                'title' => 'Dismantling old sodium lamps',
                'description' => 'Safely uninstalled 400 old fixtures across Sectors 1-5.',
                'status' => 'completed',
                'milestone_date' => '2026-05-20',
            ]);

            $project2->milestones()->create([
                'title' => 'Installing new smart LED hubs',
                'description' => 'Fitted and synced smart energy meters.',
                'status' => 'completed',
                'milestone_date' => '2026-06-02',
            ]);
        }
    }
}
