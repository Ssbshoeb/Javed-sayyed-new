<?php
/**
 * includes/practice-data.php — Content for the individual practice-area pages.
 *
 * One entry per page, keyed by the page's file name (without .php). Each page
 * targets the search phrase people actually type ("criminal lawyer in Pune"),
 * so the keyword appears in the URL, <title>, H1 and body text.
 *
 * Wording rules (Bar Council of India): describe the work and the law only.
 * No "best", "top", "expert", "No. 1", success rates, fees or testimonials.
 *
 * Keys per entry:
 *   name      short name shown in lists (matches AREAS_OF_LAW in config.php)
 *   h1        page heading
 *   title     <title> tag
 *   desc      meta description (~150–160 characters)
 *   lead      opening paragraph
 *   sections  [heading => [paragraphs…] | ['list' => [items…], 'intro' => '…']]
 *   faqs      [question => answer]
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

$practicePages = [

    'criminal-lawyer-pune' => [
        'name'  => 'Criminal Law',
        'h1'    => 'Criminal Lawyer in Pune',
        'title' => 'Criminal Lawyer in Pune | Bail, Anticipatory Bail & Trials | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, criminal lawyer in Pune: bail and anticipatory bail, criminal trials, quashing of FIRs and appeals before Pune courts and the Bombay High Court.',
        'lead'  => 'Adv. Javed Pashu Sayyed appears in criminal matters from Chamber No. 52/B at the District & Sessions Court, Shivajinagar, Pune — from bail and anticipatory bail applications to full trials, quashing petitions and criminal appeals before the Bombay High Court and the Supreme Court of India.',
        'sections' => [
            'Criminal matters handled' => [
                'list' => [
                    'Anticipatory bail applications before the Sessions Court, Pune and the Bombay High Court',
                    'Regular bail after arrest, and bail in appeal',
                    'Defence in criminal trials before JMFC courts and Sessions Courts',
                    'Petitions to quash FIRs and criminal proceedings before the Bombay High Court',
                    'Criminal appeals and revisions',
                    'Private criminal complaints and representation of complainants and victims',
                ],
            ],
            'The new criminal laws' => [
                'Since 1 July 2024 the Bharatiya Nyaya Sanhita, 2023 (BNS), the Bharatiya Nagarik Suraksha Sanhita, 2023 (BNSS) and the Bharatiya Sakshya Adhiniyam, 2023 (BSA) have replaced the Indian Penal Code, the Code of Criminal Procedure and the Indian Evidence Act. Anticipatory bail is now sought under Section 482 BNSS (formerly Section 438 CrPC), and regular bail under Sections 480 and 483 BNSS (formerly Sections 437 and 439 CrPC).',
                'Offences committed before 1 July 2024, and proceedings already pending on that date, can still be governed by the old codes. Which law applies to a particular FIR is one of the first things checked when the papers are read.',
            ],
            'Criminal courts in Pune' => [
                'Criminal cases in Pune are heard by the courts of the Judicial Magistrate (First Class) and by the Sessions Court at the District & Sessions Court complex, Shivajinagar. Bail applications that are refused there, quashing petitions and criminal appeals go to the Bombay High Court, and from there to the Supreme Court of India.',
            ],
            'What to bring to a consultation' => [
                'list' => [
                    'A copy of the FIR or complaint, if one has been registered',
                    'Any notice received from the police (for example, a notice to appear)',
                    'Earlier bail orders, charge-sheet or court orders, if any',
                    'A short written timeline of events in your own words',
                ],
            ],
        ],
        'faqs' => [
            'Can I apply for anticipatory bail before an FIR is registered?' =>
                'Anticipatory bail can be sought when a person has a reasonable belief that they may be arrested for a non-bailable offence. An FIR does not always have to be registered first, but the application must show specific, concrete grounds for that apprehension.',
            'Where is anticipatory bail filed in Pune?' =>
                'An application is usually filed first before the Sessions Court, Pune. The Bombay High Court also has the power to grant anticipatory bail, whether directly or after the Sessions Court has refused it.',
            'Can an FIR be cancelled?' =>
                'The Bombay High Court can quash an FIR or criminal proceedings under its inherent powers (Section 528 BNSS, formerly Section 482 CrPC) and under Article 226 of the Constitution — for example, where the allegations do not disclose an offence or the dispute has been settled in certain types of cases.',
            'How do I book a consultation for a criminal matter?' =>
                'Use the enquiry form on this website or email adv.syedhc@gmail.com. If there is an arrest, a hearing date or a deadline, mention it in the subject line.',
        ],
    ],

    'family-lawyer-pune' => [
        'name'  => 'Family Law',
        'h1'    => 'Family & Divorce Lawyer in Pune',
        'title' => 'Divorce & Family Lawyer in Pune | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, family and divorce lawyer in Pune: mutual consent and contested divorce, maintenance, child custody and domestic violence cases at the Family Court, Pune.',
        'lead'  => 'Family disputes are handled by Adv. Javed Pashu Sayyed before the Family Court, Pune, the magistrates’ courts and the Bombay High Court — divorce by mutual consent or contested, maintenance, custody of children and protection under the Domestic Violence Act.',
        'sections' => [
            'Family matters handled' => [
                'list' => [
                    'Divorce by mutual consent',
                    'Contested divorce, judicial separation and restitution of conjugal rights',
                    'Maintenance for wife, children and parents',
                    'Child custody, guardianship and visitation rights',
                    'Proceedings under the Protection of Women from Domestic Violence Act, 2005',
                    'Appeals in family matters before the Bombay High Court',
                ],
            ],
            'Which law applies' => [
                'The law that governs a marriage depends on the parties’ religion and on how the marriage was registered. Hindu, Buddhist, Jain and Sikh marriages fall under the Hindu Marriage Act, 1955; marriages registered under the Special Marriage Act, 1954 are governed by that Act; Muslim marriages are governed by personal law and statutes such as the Dissolution of Muslim Marriages Act, 1939. Custody questions are decided under the Guardians and Wards Act, 1890 and the personal law, with the welfare of the child as the first consideration.',
                'Maintenance can be claimed under the personal law, under Section 144 of the BNSS (formerly Section 125 CrPC), and under the Domestic Violence Act, depending on the circumstances.',
            ],
            'Mutual consent divorce' => [
                'Under Section 13B of the Hindu Marriage Act, both spouses file a joint petition after living separately for at least one year. The Act provides for a six-month interval before the second motion; the Supreme Court has held that the Family Court may waive this period in suitable cases. Terms such as alimony, custody and return of belongings are recorded in writing before filing.',
            ],
            'What to bring to a consultation' => [
                'list' => [
                    'Marriage certificate or proof of marriage',
                    'Any notice, petition or court order already received',
                    'Details of income, children and the date of separation',
                ],
            ],
        ],
        'faqs' => [
            'How long does a mutual consent divorce take in Pune?' =>
                'After the first motion, the Act provides a six-month period before the second motion, which the court may waive in suitable cases. The overall time depends on the court’s calendar and on whether the settlement terms are complete when the petition is filed.',
            'Where are divorce cases filed in Pune?' =>
                'Matrimonial cases in Pune are heard by the Family Court, Pune. The petition can generally be filed where the marriage was solemnised, where the parties last lived together, or where the respondent lives; in some cases where the wife lives.',
            'Can maintenance be claimed without filing for divorce?' =>
                'Yes. A spouse can claim maintenance under Section 144 BNSS or under the Domestic Violence Act without seeking divorce.',
        ],
    ],

    'corporate-lawyer-pune' => [
        'name'  => 'Corporate Law',
        'h1'    => 'Corporate & Commercial Lawyer in Pune',
        'title' => 'Corporate & Commercial Lawyer in Pune | Contracts & Business Disputes | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed advises businesses in Pune on contracts, legal notices and commercial disputes, and represents them before commercial courts and the Bombay High Court.',
        'lead'  => 'Businesses, partners and company directors in Pune come to Adv. Javed Pashu Sayyed for contracts that need to be drafted or reviewed, for legal notices, and for commercial disputes that need to be settled or taken to court.',
        'sections' => [
            'Work for businesses' => [
                'list' => [
                    'Drafting and review of commercial contracts, service agreements and partnership deeds',
                    'Legal notices and replies',
                    'Recovery of dues and commercial suits',
                    'Disputes between partners, shareholders and directors',
                    'Day-to-day legal advice for small and medium businesses',
                ],
            ],
            'Commercial disputes' => [
                'Commercial disputes of a specified value of ₹3 lakh or more are heard by commercial courts under the Commercial Courts Act, 2015. Before most such suits can be filed, the Act requires the parties to attempt pre-institution mediation under Section 12A, unless urgent interim relief is needed. Many contracts also contain an arbitration clause, which changes where and how the dispute is decided — see arbitration and dispute resolution.',
            ],
            'Why the contract is read first' => [
                'Most business disputes turn on the words of the agreement: the payment terms, notice periods, termination clause, jurisdiction clause and any arbitration clause. Bring the signed contract, the correspondence and the invoices, so advice can be given on the document rather than on a summary of it.',
            ],
        ],
        'faqs' => [
            'Is mediation compulsory before filing a commercial suit?' =>
                'Under Section 12A of the Commercial Courts Act, pre-institution mediation is mandatory for commercial suits that do not seek urgent interim relief.',
            'Can you review a contract before I sign it?' =>
                'Yes. Contract review before signing is one of the most useful forms of legal advice, because it prevents disputes rather than resolving them.',
        ],
    ],

    'arbitration-lawyer-pune' => [
        'name'  => 'Arbitration & Dispute Resolution',
        'h1'    => 'Arbitration Lawyer in Pune',
        'title' => 'Arbitration Lawyer in Pune | Arbitration, Mediation & Awards | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, arbitration lawyer in Pune: arbitration proceedings, interim relief, mediation, and challenges to or enforcement of arbitral awards.',
        'lead'  => 'Where a contract contains an arbitration clause, the dispute is usually decided by an arbitral tribunal rather than a civil court. Adv. Javed Pashu Sayyed represents parties in arbitration proceedings, mediation, and court applications connected with arbitration in Pune and before the Bombay High Court.',
        'sections' => [
            'Arbitration matters handled' => [
                'list' => [
                    'Invoking arbitration and appointment of arbitrators (Section 11)',
                    'Interim measures from the court (Section 9) or the tribunal (Section 17)',
                    'Conduct of arbitration proceedings — pleadings, evidence and arguments',
                    'Challenges to arbitral awards (Section 34)',
                    'Enforcement of arbitral awards (Section 36)',
                    'Mediation and negotiated settlement',
                ],
            ],
            'The law' => [
                'Arbitration in India is governed by the Arbitration and Conciliation Act, 1996. An application to set aside an award under Section 34 must be filed within three months of receiving the award, extendable by a further thirty days only on sufficient cause — after that, the court cannot condone the delay. Deadlines in arbitration are strict, so the award or notice should be brought in as soon as it is received.',
            ],
        ],
        'faqs' => [
            'How long do I have to challenge an arbitral award?' =>
                'Three months from the date the award is received, with a further thirty days only if sufficient cause is shown. No further extension is possible.',
            'Can I go to court urgently even though there is an arbitration clause?' =>
                'Yes. Under Section 9 of the Arbitration Act, a court can grant interim protection — for example, to stop assets being sold — before, during or after arbitration.',
        ],
    ],

    'cyber-crime-lawyer-pune' => [
        'name'  => 'Cyber Crime Law',
        'h1'    => 'Cyber Crime Lawyer in Pune',
        'title' => 'Cyber Crime Lawyer in Pune | Online Fraud & Cyber Complaints | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, cyber crime lawyer in Pune: online and UPI fraud, hacking, identity theft, cyber complaints and defence in cyber crime cases.',
        'lead'  => 'Online fraud, hacked accounts, identity theft and harassment on social media are now among the most common criminal complaints in Pune. Adv. Javed Pashu Sayyed advises victims on complaints and follow-up, and represents persons accused in cyber crime cases.',
        'sections' => [
            'Cyber matters handled' => [
                'list' => [
                    'Online banking, UPI and investment fraud',
                    'Hacking of email and social-media accounts',
                    'Identity theft and impersonation',
                    'Online harassment, defamation and morphed images',
                    'Data theft by employees or business associates',
                    'Bail and defence for persons accused of cyber offences',
                ],
            ],
            'What to do immediately after online fraud' => [
                'Report financial fraud as quickly as possible on the national cyber crime helpline 1930 or at cybercrime.gov.in — speed matters, because the money can sometimes be frozen before it is withdrawn. Inform your bank at once, and keep screenshots, transaction IDs, phone numbers and messages. A complaint can also be made at the Cyber Police Station or the local police station in Pune.',
            ],
            'The law' => [
                'Cyber offences are dealt with under the Information Technology Act, 2000 — for example, identity theft (Section 66C) and cheating by personation using a computer resource (Section 66D) — together with the Bharatiya Nyaya Sanhita, 2023 for cheating, extortion and defamation.',
            ],
        ],
        'faqs' => [
            'Can money lost in online fraud be recovered?' =>
                'Sometimes. If the fraud is reported quickly on 1930 or cybercrime.gov.in, the amount can be frozen in the receiving account. Release of frozen money then usually needs an application before the court.',
            'The police are not registering my cyber complaint. What can I do?' =>
                'You can approach senior police officers in writing, and a magistrate can direct investigation on an application made under the BNSS. Advice depends on the facts of the complaint.',
        ],
    ],

    'property-lawyer-pune' => [
        'name'  => 'Property Law',
        'h1'    => 'Property Lawyer in Pune',
        'title' => 'Property Lawyer in Pune | Title, Sale Deed & Property Disputes | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, property lawyer in Pune: title verification, sale deeds, leave and licence agreements, possession suits and property disputes.',
        'lead'  => 'Buying, selling or letting property in Pune, and disputes over land, flats and possession, are handled by Adv. Javed Pashu Sayyed — from checking title before a purchase to filing and defending suits in the civil courts.',
        'sections' => [
            'Property matters handled' => [
                'list' => [
                    'Title search and verification before buying a flat or land',
                    'Drafting and review of sale deeds, agreements for sale and gift deeds',
                    'Leave and licence (rental) agreements',
                    'Suits for possession, injunction and specific performance',
                    'Partition and inheritance disputes',
                    'Complaints against builders, including before MahaRERA',
                ],
            ],
            'The law' => [
                'Property transactions are governed by the Transfer of Property Act, 1882 and the Registration Act, 1908; suits for specific performance and injunctions by the Specific Relief Act, 1963. In Maharashtra, leave and licence agreements must be registered under the Maharashtra Rent Control Act, 1999, and disputes with developers over registered projects can be taken to MahaRERA under the Real Estate (Regulation and Development) Act, 2016.',
            ],
            'Documents to bring' => [
                'list' => [
                    '7/12 extract or property card, and the index-II of earlier transactions',
                    'Previous sale deeds or the chain of title',
                    'The draft or signed agreement, and any notice received',
                ],
            ],
        ],
        'faqs' => [
            'Should I get the title checked before buying a flat in Pune?' =>
                'Yes. A title search confirms that the seller has a clear right to sell and that the property is not subject to undisclosed mortgages, litigation or claims.',
            'Is registration of a rent agreement compulsory in Maharashtra?' =>
                'Yes. Section 55 of the Maharashtra Rent Control Act, 1999 requires leave and licence agreements to be in writing and registered.',
        ],
    ],

    'consumer-court-lawyer-pune' => [
        'name'  => 'Consumer Law',
        'h1'    => 'Consumer Court Lawyer in Pune',
        'title' => 'Consumer Court Lawyer in Pune | Consumer Complaints | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, consumer court lawyer in Pune: complaints for defective goods, deficient services, insurance claims and builder delays before the consumer commissions.',
        'lead'  => 'When goods are defective or a service falls short — an insurance claim wrongly rejected, a flat not handed over, a bank charge that should not have been levied — a complaint can be filed before a consumer commission. Adv. Javed Pashu Sayyed files and defends such complaints in Pune.',
        'sections' => [
            'Consumer matters handled' => [
                'list' => [
                    'Defective products and refunds',
                    'Deficiency in service by banks, telecom, e-commerce and service providers',
                    'Rejected or short-settled insurance claims',
                    'Delay in possession by builders',
                    'Medical negligence complaints',
                    'Appeals before the State and National Commissions',
                ],
            ],
            'Which commission hears the complaint' => [
                'Under the Consumer Protection Act, 2019, and the pecuniary limits notified in 2021, complaints up to ₹50 lakh go to the District Consumer Disputes Redressal Commission (in Pune, the District Commission, Pune); from ₹50 lakh to ₹2 crore to the Maharashtra State Commission; and above ₹2 crore to the National Commission in New Delhi. A complaint should ordinarily be filed within two years of the cause of action.',
            ],
        ],
        'faqs' => [
            'Do I need a lawyer to file a consumer complaint?' =>
                'The law allows a consumer to file a complaint personally. Legal help is useful for drafting the complaint, choosing the right commission, and presenting evidence, especially where the other side is represented.',
            'What is the time limit for a consumer complaint?' =>
                'Two years from the date the cause of action arises. Delay can be condoned only if sufficient cause is shown.',
        ],
    ],

    'human-rights-lawyer-pune' => [
        'name'  => 'Human Rights Law',
        'h1'    => 'Human Rights & Writ Petition Lawyer in Pune',
        'title' => 'Human Rights & Writ Petition Lawyer | Bombay High Court | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed files writ petitions before the Bombay High Court and the Supreme Court where fundamental rights are at stake: illegal detention, police inaction and state action.',
        'lead'  => 'Where the State, the police or a public authority acts unlawfully, the Constitution allows a direct approach to the High Court or the Supreme Court. Adv. Javed Pashu Sayyed files writ petitions and representations in such matters.',
        'sections' => [
            'Matters handled' => [
                'list' => [
                    'Writ petitions under Article 226 before the Bombay High Court',
                    'Petitions under Article 32 before the Supreme Court of India',
                    'Habeas corpus petitions for illegal detention',
                    'Police inaction and failure to register complaints',
                    'Representations before human rights commissions',
                ],
            ],
            'The law' => [
                'Article 226 empowers the High Courts to issue writs — habeas corpus, mandamus, certiorari, prohibition and quo warranto — for the enforcement of fundamental rights and for other purposes. Article 32 gives the right to approach the Supreme Court directly for enforcement of fundamental rights. The Protection of Human Rights Act, 1993 set up the National and State Human Rights Commissions, including the Maharashtra State Human Rights Commission.',
            ],
        ],
        'faqs' => [
            'What is a habeas corpus petition?' =>
                'A petition asking the court to direct that a person held in custody be produced, so the court can examine whether the detention is lawful. It can be filed by the detained person or by someone on their behalf.',
            'Should I go to the High Court or the Supreme Court first?' =>
                'In most cases the High Court under Article 226 is the first forum, because its powers are wider and it is closer to the facts. The right choice depends on the matter.',
        ],
    ],

    'immigration-lawyer-pune' => [
        'name'  => 'Immigration Law',
        'h1'    => 'Passport, Visa & OCI Lawyer in Pune',
        'title' => 'Passport, Visa & OCI Lawyer in Pune | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed advises on passport refusal and impounding, visa and OCI matters in Pune, and files proceedings where an authority’s decision needs to be challenged.',
        'lead'  => 'A refused or impounded passport, a pending criminal case that stands in the way of travel, or a problem with an OCI card can all need legal help. Adv. Javed Pashu Sayyed advises on these matters and takes them to court where required.',
        'sections' => [
            'Matters handled' => [
                'list' => [
                    'Passport refusal, impounding and revocation',
                    'Permission to travel abroad when a criminal case is pending',
                    'Look-out circulars and travel restrictions',
                    'OCI registration and cancellation issues',
                    'Visa and foreigner-registration matters',
                ],
            ],
            'The law' => [
                'Passports are issued, refused and impounded under the Passports Act, 1967; in Pune, applications are handled by the Regional Passport Office. OCI registration and cancellation are governed by Sections 7A to 7D of the Citizenship Act, 1955. Decisions of these authorities can be challenged in appeal and, where needed, before the Bombay High Court.',
            ],
        ],
        'faqs' => [
            'Can I travel abroad if a criminal case is pending against me?' =>
                'Often yes, but usually only with the permission of the court where the case is pending. The court may impose conditions such as a surety or an undertaking to return.',
            'My passport has been refused because of a police report. What can I do?' =>
                'The refusal can be challenged, and the position of the pending case, if any, needs to be looked at. Bring the refusal letter and the case papers.',
        ],
    ],

    'intellectual-property-lawyer-pune' => [
        'name'  => 'Intellectual Property Law',
        'h1'    => 'Trademark & Copyright Lawyer in Pune',
        'title' => 'Trademark & Copyright Lawyer in Pune | IP Disputes | Adv. Javed Pashu Sayyed',
        'desc'  => 'Adv. Javed Pashu Sayyed, trademark and copyright lawyer in Pune: trademark registration and objections, oppositions, and infringement and passing-off disputes.',
        'lead'  => 'A brand name, logo or creative work is often a business’s most valuable asset. Adv. Javed Pashu Sayyed advises on protecting trademarks and copyright, and represents clients when someone else copies them.',
        'sections' => [
            'IP matters handled' => [
                'list' => [
                    'Trademark search and registration',
                    'Replies to examination reports and hearings',
                    'Trademark oppositions',
                    'Copyright protection and registration',
                    'Cease-and-desist notices',
                    'Infringement and passing-off suits',
                ],
            ],
            'The law' => [
                'Trademarks are registered and protected under the Trade Marks Act, 1999 through the Trade Marks Registry; copyright is protected under the Copyright Act, 1957. An unregistered mark can still be protected through a passing-off action. Intellectual property disputes are commercial disputes under the Commercial Courts Act, 2015.',
            ],
        ],
        'faqs' => [
            'Can I use ™ before my trademark is registered?' =>
                'Yes. ™ can be used with an unregistered mark to indicate a claim. The ® symbol may be used only once the mark is registered.',
            'Someone is copying my brand name. What can I do?' =>
                'Usually the first step is a legal notice. If copying continues, a suit for infringement (for a registered mark) or passing off can be filed, along with an application for an interim injunction.',
        ],
    ],
];
