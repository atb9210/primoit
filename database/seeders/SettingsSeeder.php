<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Impostazioni aziendali
        $this->createCompanySettings();
        
        // Impostazioni di contatto
        $this->createContactSettings();
        
        // Impostazioni social
        $this->createSocialSettings();
        
        // Impostazioni PDF e documenti
        $this->createDocumentSettings();
        
        // Impostazioni SEO
        $this->createSeoSettings();
    }
    
    /**
     * Crea le impostazioni aziendali di base
     */
    private function createCompanySettings(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'name' => 'Nome Azienda',
                'value' => 'PrimoIT',
                'description' => 'Nome completo dell\'azienda',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_legal_name',
                'name' => 'Ragione Sociale',
                'value' => 'PrimoIT S.r.l.',
                'description' => 'Ragione sociale completa dell\'azienda',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_vat',
                'name' => 'Partita IVA',
                'value' => '12345678901',
                'description' => 'Partita IVA dell\'azienda',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_fiscal_code',
                'name' => 'Codice Fiscale',
                'value' => '12345678901',
                'description' => 'Codice fiscale dell\'azienda',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_address',
                'name' => 'Indirizzo',
                'value' => 'Via Roma, 1',
                'description' => 'Indirizzo della sede legale',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_city',
                'name' => 'Città',
                'value' => 'Milano',
                'description' => 'Città della sede legale',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_zip',
                'name' => 'CAP',
                'value' => '20100',
                'description' => 'CAP della sede legale',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_province',
                'name' => 'Provincia',
                'value' => 'MI',
                'description' => 'Provincia della sede legale',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_country',
                'name' => 'Paese',
                'value' => 'Italia',
                'description' => 'Paese della sede legale',
                'group' => 'company',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'company_logo',
                'name' => 'Logo Aziendale',
                'value' => null,
                'description' => 'Logo dell\'azienda (formato consigliato: 300x100px, PNG con sfondo trasparente)',
                'group' => 'company',
                'type' => 'image',
                'is_public' => true,
            ],
            [
                'key' => 'company_logo_dark',
                'name' => 'Logo Aziendale (Dark Mode)',
                'value' => null,
                'description' => 'Versione del logo per sfondi scuri (formato consigliato: 300x100px, PNG con sfondo trasparente)',
                'group' => 'company',
                'type' => 'image',
                'is_public' => true,
            ],
            [
                'key' => 'company_favicon',
                'name' => 'Favicon',
                'value' => null,
                'description' => 'Icona del sito (formato consigliato: 32x32px, PNG)',
                'group' => 'company',
                'type' => 'image',
                'is_public' => true,
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
    
    /**
     * Crea le impostazioni di contatto
     */
    private function createContactSettings(): void
    {
        $settings = [
            [
                'key' => 'contact_email',
                'name' => 'Email di Contatto',
                'value' => 'info@primoit.com',
                'description' => 'Email principale di contatto',
                'group' => 'contact',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'name' => 'Telefono',
                'value' => '+39 123 456 7890',
                'description' => 'Numero di telefono principale',
                'group' => 'contact',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'contact_whatsapp',
                'name' => 'WhatsApp',
                'value' => '+39 123 456 7890',
                'description' => 'Numero WhatsApp per contatti rapidi',
                'group' => 'contact',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'contact_form_recipients',
                'name' => 'Destinatari Form Contatti',
                'value' => 'info@primoit.com',
                'description' => 'Indirizzi email che riceveranno i messaggi dal form di contatto (separati da virgola)',
                'group' => 'contact',
                'type' => 'text',
                'is_public' => false,
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
    
    /**
     * Crea le impostazioni per i social media
     */
    private function createSocialSettings(): void
    {
        $settings = [
            [
                'key' => 'social_facebook',
                'name' => 'Facebook',
                'value' => 'https://facebook.com/primoit',
                'description' => 'URL della pagina Facebook',
                'group' => 'social',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'social_instagram',
                'name' => 'Instagram',
                'value' => 'https://instagram.com/primoit',
                'description' => 'URL del profilo Instagram',
                'group' => 'social',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'social_linkedin',
                'name' => 'LinkedIn',
                'value' => 'https://linkedin.com/company/primoit',
                'description' => 'URL della pagina LinkedIn',
                'group' => 'social',
                'type' => 'text',
                'is_public' => true,
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
    
    /**
     * Crea le impostazioni per documenti e PDF
     */
    private function createDocumentSettings(): void
    {
        $settings = [
            [
                'key' => 'document_header',
                'name' => 'Intestazione Documenti',
                'value' => '',
                'description' => 'Testo da mostrare nell\'intestazione dei documenti',
                'group' => 'document',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'document_footer',
                'name' => 'Piè di Pagina Documenti',
                'value' => 'PrimoIT S.r.l. - P.IVA 12345678901 - Tutti i diritti riservati',
                'description' => 'Testo da mostrare nel piè di pagina dei documenti',
                'group' => 'document',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'document_primary_color',
                'name' => 'Colore Primario Documenti',
                'value' => '#0f2b46',
                'description' => 'Colore primario per i documenti (es. intestazioni tabelle)',
                'group' => 'document',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'document_logo',
                'name' => 'Logo per Documenti',
                'value' => null,
                'description' => 'Logo specifico per documenti e PDF',
                'group' => 'document',
                'type' => 'image',
                'is_public' => false,
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
    
    /**
     * Crea le impostazioni SEO
     */
    private function createSeoSettings(): void
    {
        $settings = [
            [
                'key' => 'seo_title',
                'name' => 'Titolo SEO',
                'value' => 'PrimoIT - Soluzioni IT Professionali',
                'description' => 'Titolo SEO predefinito per le pagine',
                'group' => 'seo',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'seo_description',
                'name' => 'Descrizione SEO',
                'value' => 'PrimoIT offre soluzioni IT professionali per aziende di ogni dimensione. Contattaci per una consulenza gratuita.',
                'description' => 'Descrizione SEO predefinita per le pagine',
                'group' => 'seo',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'seo_keywords',
                'name' => 'Parole Chiave SEO',
                'value' => 'primoit, it, soluzioni, professionali, aziende',
                'description' => 'Parole chiave SEO predefinite per le pagine',
                'group' => 'seo',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'google_analytics_id',
                'name' => 'ID Google Analytics',
                'value' => '',
                'description' => 'ID di tracciamento Google Analytics',
                'group' => 'seo',
                'type' => 'text',
                'is_public' => true,
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
