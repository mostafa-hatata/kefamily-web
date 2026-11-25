<?php
/**
 * KeFamily content dictionary (Arabic + English).
 * All site copy lives here so both languages stay in sync.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

/**
 * Brand data shared by both languages (non-translatable).
 */
function kf_brands_meta() {
	return array(
		'kepixel'  => array(
			'name'  => 'KePixel',
			'url'   => 'https://kepixel.online',
			'host'  => 'kepixel.online',
			'color' => '#8B5CF6',
			'glow'  => '139, 92, 246',
		),
		'kemarq'   => array(
			'name'  => 'KeMarq',
			'url'   => 'https://kemarq.net',
			'host'  => 'kemarq.net',
			'color' => '#FF7A45',
			'glow'  => '255, 122, 69',
		),
		'kechat'   => array(
			'name'  => 'KeChat',
			'url'   => 'https://kechat.online',
			'host'  => 'kechat.online',
			'color' => '#22D39A',
			'glow'  => '34, 211, 154',
		),
		'keclinic' => array(
			'name'  => 'KeClinic',
			'url'   => '',
			'host'  => '',
			'color' => '#FACC15',
			'glow'  => '250, 204, 21',
		),
	);
}

/**
 * Translatable copy.
 */
function kf_content() {
	static $content = null;
	if ( null !== $content ) {
		return $content;
	}

	$content = array(
		'ar' => array(
			'meta'      => array(
				'title'       => 'KeFamily — الشركة الأم لـ KePixel وKeMarq وKeChat وKeClinic',
				'description' => 'KeFamily تجمع أربع شركات تقنية وتسويقية تحت سقف واحد: تسويق الأداء، التتبّع من السيرفر، أتمتة واتساب، وإدارة نمو العيادات — من أول إعلان حتى عودة العميل.',
			),
			'nav'       => array(
				'home'      => 'الرئيسية',
				'companies' => 'شركاتنا',
				'ecosystem' => 'كيف نعمل',
				'about'     => 'من نحن',
				'contact'   => 'تواصل معنا',
				'cta'       => 'ابدأ مشروعك',
				'menu'      => 'القائمة',
				'close'     => 'إغلاق',
				'switch'    => 'English',
				'skip'      => 'انتقل إلى المحتوى',
			),
			'hero'      => array(
				'eyebrow' => 'الشركة الأم لأربع شركات تقنية وتسويقية',
				'title_a' => 'عائلة واحدة',
				'rotate'  => array( 'تجلب لك العميل', 'تقيس كل خطوة', 'تحوّل المحادثة إلى بيع', 'تنظّم عيادتك' ),
				'sub'     => 'KeFamily تجمع KePixel وKeMarq وKeChat وKeClinic تحت سقف واحد — من أول إعلان يراه عميلك، حتى يشتري أو يحجز ويعود مرة أخرى.',
				'cta1'    => 'اكتشف شركاتنا',
				'cta2'    => 'تحدّث معنا على واتساب',
				'scroll'  => 'مرّر للأسفل',
				'core'    => 'العائلة',
			),
			'marquee'   => array( 'تتبّع من السيرفر', 'إعلانات الأداء', 'أتمتة واتساب', 'حجوزات العيادات', 'Meta', 'Snapchat', 'TikTok', 'Google Ads', 'GA4', 'سلة', 'زد', 'Shopify', 'WordPress', 'صندوق وارد مشترك', 'تقارير موحّدة', 'رؤى بالذكاء الاصطناعي' ),
			'companies' => array(
				'eyebrow' => 'شركات العائلة',
				'title'   => 'أربع شركات. هدف واحد: نموّ يمكن قياسه.',
				'sub'     => 'كل شركة متخصصة في مرحلة من رحلة العميل، وكلها تعمل على البيانات نفسها.',
				'visit'   => 'زيارة الموقع',
				'more'    => 'التفاصيل',
				'soon'    => 'قريباً',
				'items'   => array(
					'kepixel'  => array(
						'tag'      => 'منصة التتبّع من السيرفر',
						'headline' => 'كل حركة عميل تصبح إشارة تحويل نظيفة.',
						'desc'     => 'منصة تتبّع من جهة السيرفر ترسل بيانات أدقّ لمنصات الإعلانات: إزالة التكرار، توحيد هوية العميل، ورحلة إسناد كاملة — بإعداد يستغرق أقل من دقيقة.',
						'points'   => array( 'تتبّع من السيرفر بالكامل', 'ربط سلة وزد وShopify وWordPress والتطبيقات', 'إرسال إلى Meta وSnapchat وTikTok وGoogle Ads وGA4' ),
						'long'     => 'المتصفحات وأدوات حظر الإعلانات تُضيّع جزءاً كبيراً من بيانات التحويل، فتتعلّم خوارزميات الإعلانات من صورة ناقصة. KePixel تلتقط الأحداث من السيرفر، تنظّفها، تزيل المكرر منها وتربطها بهوية العميل، ثم ترسلها لكل منصة إعلانية بالشكل الذي تفهمه.',
						'features' => array(
							array( 'التتبّع من السيرفر', 'بيانات لا تتأثر بحظر المتصفحات وأدوات منع الإعلانات.' ),
							array( 'إزالة التكرار', 'كل عملية شراء تُحسب مرة واحدة فقط على كل منصة.' ),
							array( 'توحيد الهوية', 'ملف واحد لكل عميل عبر الأجهزة والقنوات.' ),
							array( 'رحلة الإسناد', 'اعرف أي حملة بدأت الرحلة وأيها أغلقت البيع.' ),
							array( 'الإيرادات والطلبات', 'قيمة كل طلب تصل للمنصة لتحسين العائد على الإنفاق.' ),
							array( 'رؤى بالذكاء الاصطناعي', 'ملخصات واضحة لما يحدث في بياناتك وماذا تفعل بعدها.' ),
						),
					),
					'kemarq'   => array(
						'tag'      => 'وكالة تسويق أداء متكاملة',
						'headline' => 'فريق واحد يدير إعلاناتك.',
						'desc'     => 'خطة الحملات، المحتوى، التصميم، الموقع والتقارير — مع فريق واحد مسؤول عن النتيجة، وتقرير واحد يوضّح ما حدث.',
						'points'   => array( 'إعلانات Meta وSnapchat وTikTok وGoogle وX', 'محتوى وتصوير وفيديو وهوية بصرية', 'مواقع وصفحات هبوط وSEO' ),
						'long'     => 'بدلاً من التنسيق بين مصمم ومشتري إعلانات ومطوّر ومحلل بيانات، KeMarq تقدّم التسويق كباقة واحدة متكاملة. الحملات مبنية على بيانات تتبّع دقيقة، والمحتوى مصمّم لكل منصة، وكل شيء يُقاس في تقرير واحد.',
						'features' => array(
							array( 'الإعلانات المدفوعة', 'Meta وSnapchat وTikTok وGoogle وX بإدارة يومية.' ),
							array( 'إدارة السوشيال ميديا', 'خطة محتوى ونشر وتفاعل على كل المنصات.' ),
							array( 'المحتوى والتصوير', 'تصوير وفيديو ومحتوى مصمّم ليبيع.' ),
							array( 'التصميم والهوية', 'هوية بصرية متكاملة وتصاميم إعلانية.' ),
							array( 'المواقع وصفحات الهبوط', 'صفحات سريعة مبنية لتحويل الزائر إلى عميل.' ),
							array( 'التتبّع والتقارير وSEO', 'Pixel وConversions API وGA4 وتحسين محركات البحث.' ),
						),
					),
					'kechat'   => array(
						'tag'      => 'منصة واتساب للأعمال',
						'headline' => 'حوّل واتساب إلى أقوى قناة مبيعات.',
						'desc'     => 'حملات جماعية، صندوق وارد مشترك لفريقك، وأتمتة للحجوزات والتذكيرات والمتابعة — على رقمك أنت.',
						'points'   => array( 'حملات للعملاء الموافقين فقط', 'صندوق وارد مشترك وأدوار للفريق', 'تذكيرات الحجز وتكامل Clinicea وAPI' ),
						'long'     => 'عملاؤك موجودون على واتساب أصلاً. KeChat تحوّل رقم شركتك إلى قناة مبيعات منظّمة: فريقك يرد من صندوق واحد، الحملات تصل للعملاء الموافقين فقط، والتذكيرات والتأكيدات تعمل تلقائياً.',
						'features' => array(
							array( 'حملات جماعية', 'رسائل لشرائح محددة بحدّ إرسال يومي آمن.' ),
							array( 'قوالب بالصور', 'قوالب قابلة لإعادة الاستخدام مع اسم العميل والتاريخ.' ),
							array( 'صندوق وارد مشترك', 'فريقك كله يرد من رقم واحد.' ),
							array( 'الأتمتة', 'تأكيد الحجز والتذكير والإلغاء وطلب التقييم تلقائياً.' ),
							array( 'جهات الاتصال', 'استيراد من Excel وCSV مع الشرائح وسجلات الموافقة.' ),
							array( 'API وWebhooks', 'اربطها بأنظمتك وبنظام الحجوزات.' ),
						),
					),
					'keclinic' => array(
						'tag'      => 'حلول نمو العيادات',
						'headline' => 'عيادة ممتلئة بالمواعيد، ومرضى يعودون.',
						'desc'     => 'حلول مخصّصة للعيادات تربط الإعلان بالحجز وبالزيارة، مع متابعة المريض وقياس العائد من كل حملة.',
						'points'   => array( 'حجوزات وتذكيرات تلقائية', 'متابعة المرضى بعد الزيارة', 'قياس العائد من كل حملة' ),
						'long'     => 'العيادات تخسر جزءاً من مرضاها بين الإعلان والحجز وبين الحجز والزيارة. KeClinic تجمع خبرة العائلة في نظام واحد للعيادات: الحملة تجلب المريض، الحجز يُؤكَّد ويُذكَّر به تلقائياً، والمتابعة بعد الزيارة تعيده مرة أخرى.',
						'features' => array(
							array( 'من الإعلان إلى الحجز', 'كل حجز مربوط بالحملة التي جاء منها.' ),
							array( 'تذكيرات تلقائية', 'تقليل حالات عدم الحضور برسائل في الوقت المناسب.' ),
							array( 'متابعة المريض', 'رسائل ما بعد الزيارة والتقييم وإعادة الحجز.' ),
							array( 'تقارير العائد', 'اعرف تكلفة كل مريض والعائد من كل قناة.' ),
						),
					),
				),
			),
			'flow'      => array(
				'eyebrow' => 'كيف نعمل',
				'title'   => 'رحلة عميل واحدة، أربع شركات تكمّل بعضها.',
				'sub'     => 'البيانات تنتقل بين شركات العائلة دون أن تضيع، فتتحسّن كل مرحلة بما تعلّمته المرحلة السابقة.',
				'hub'     => 'KeFamily',
				'steps'   => array(
					array( 'kemarq', 'نجلب العميل', 'حملات وإبداع مبني على بيانات حقيقية.' ),
					array( 'kepixel', 'نقيس كل خطوة', 'إشارات تحويل نظيفة تغذّي خوارزميات الإعلانات.' ),
					array( 'kechat', 'نحوّل المحادثة', 'ردود وتذكيرات وحملات على واتساب.' ),
					array( 'keclinic', 'نُعيد العميل', 'حجز وزيارة ومتابعة تصنع ولاءً.' ),
				),
			),
			'stats'     => array(
				'eyebrow' => 'بالأرقام',
				'items'   => array(
					array( 4, '', 'شركات متخصصة تحت سقف واحد' ),
					array( 8, '', 'مصادر بيانات مدعومة في KePixel' ),
					array( 7, '', 'منصات إعلانية وتحليلية مرتبطة' ),
					array( 1, '', 'دقيقة أو أقل لإعداد التتبّع' ),
				),
			),
			'manifesto' => array(
				'eyebrow' => 'فلسفتنا',
				'text'    => 'لا نبيع أدوات منفصلة. نبني نظاماً واحداً تكمّل فيه كل شركة ما قبلها، وتنتقل فيه البيانات دون أن تضيع، ويُقاس فيه كل ريال يُنفق.',
			),
			'values'    => array(
				'eyebrow' => 'لماذا KeFamily',
				'title'   => 'ما يجعلنا مختلفين',
				'items'   => array(
					array( 'data', 'البيانات أولاً', 'كل قرار مبني على تتبّع دقيق من السيرفر، وليس على التخمين.' ),
					array( 'link', 'تكامل حقيقي', 'شركاتنا مبنية لتعمل معاً، لا أدوات مركّبة فوق بعضها.' ),
					array( 'chart', 'نتيجة تُقاس', 'تقرير واحد يوضّح ما أُنفق وما عاد.' ),
					array( 'team', 'فريق واحد مسؤول', 'جهة واحدة تتحمّل النتيجة من أول إعلان حتى آخر رسالة.' ),
				),
			),
			'sectors'   => array(
				'eyebrow' => 'القطاعات',
				'title'   => 'نعمل مع قطاعات تعيش على العميل المتكرر',
				'items'   => array( 'التجارة الإلكترونية', 'العيادات والمراكز الطبية', 'المدارس والتعليم', 'الجمعيات ومنصات التبرع', 'الخدمات والحجوزات', 'التطبيقات' ),
			),
			'faq'       => array(
				'eyebrow' => 'أسئلة شائعة',
				'title'   => 'كل ما تحتاج معرفته',
				'items'   => array(
					array( 'ما هي KeFamily؟', 'KeFamily هي الشركة الأم التي تجمع KePixel وKeMarq وKeChat وKeClinic. كل شركة متخصصة في مرحلة من رحلة العميل، وكلها تعمل على البيانات نفسها.' ),
					array( 'هل يجب أن أستخدم كل الشركات معاً؟', 'لا. يمكنك البدء بشركة واحدة حسب احتياجك، والإضافة لاحقاً. التكامل جاهز متى احتجته.' ),
					array( 'في أي دول تعملون؟', 'نخدم عملاءنا في المملكة العربية السعودية ومصر والخليج.' ),
					array( 'كيف أبدأ؟', 'تواصل معنا على واتساب أو من نموذج التواصل، وسنحدد معك الشركة أو الباقة الأنسب لمرحلتك.' ),
				),
			),
			'cta'       => array(
				'title' => 'جاهز تبني رحلة عميل كاملة؟',
				'sub'   => 'أخبرنا عن مشروعك، وسنقترح عليك من أين تبدأ داخل العائلة.',
				'btn1'  => 'تواصل معنا',
				'btn2'  => 'واتساب مباشر',
			),
			'about'     => array(
				'eyebrow'   => 'من نحن',
				'title'     => 'بنينا العائلة لأن العميل لا يعيش في قناة واحدة.',
				'sub'       => 'KeFamily هي الشركة الأم لمجموعة شركات وُلدت من العمل اليومي على حملات حقيقية لعملاء حقيقيين.',
				'story_t'   => 'القصة',
				'story'     => array(
					'بدأنا بإدارة الحملات الإعلانية، ولاحظنا أن جزءاً كبيراً من بيانات التحويل يضيع قبل أن يصل لمنصات الإعلانات. فبنينا KePixel للتتبّع من السيرفر.',
					'ثم رأينا أن العملاء يتواصلون عبر واتساب، وأن المحادثات تضيع بين الهواتف. فبنينا KeChat.',
					'ولأن العيادات من أكثر القطاعات حاجة لربط الإعلان بالحجز وبالزيارة، جاءت KeClinic. وKeMarq تجمع كل ذلك في خدمة تسويق متكاملة.',
					'اليوم تجمع KeFamily هذه الشركات تحت هوية واحدة، برؤية واحدة: نمو يمكن قياسه.',
				),
				'mission_t' => 'مهمتنا',
				'mission'   => 'أن نجعل كل ريال وكل جنيه يُنفق على التسويق قابلاً للقياس، وأن نحوّل كل اهتمام إلى عميل يعود.',
				'vision_t'  => 'رؤيتنا',
				'vision'    => 'أن نكون الشريك التقني والتسويقي الأول للأعمال النامية في المنطقة العربية.',
				'markets_t' => 'أسواقنا',
				'markets'   => array( 'المملكة العربية السعودية', 'مصر', 'دول الخليج' ),
			),
			'contact'   => array(
				'eyebrow'    => 'تواصل معنا',
				'title'      => 'لنتحدث عن مشروعك',
				'sub'        => 'املأ النموذج وسنرد عليك خلال يوم عمل، أو راسلنا مباشرة على واتساب.',
				'name'       => 'الاسم',
				'company'    => 'اسم الشركة',
				'email'      => 'البريد الإلكتروني',
				'phone'      => 'رقم الجوال / واتساب',
				'interest'   => 'ما الذي تحتاجه؟',
				'interests'  => array( 'غير متأكد — ساعدوني أختار', 'KePixel — التتبّع', 'KeMarq — التسويق والإعلانات', 'KeChat — واتساب', 'KeClinic — العيادات' ),
				'message'    => 'أخبرنا عن مشروعك',
				'send'       => 'إرسال',
				'sending'    => 'جارٍ الإرسال…',
				'ok'         => 'شكراً لك! وصلتنا رسالتك وسنتواصل معك قريباً.',
				'err'        => 'تعذّر الإرسال. حاول مرة أخرى أو راسلنا على واتساب.',
				'required'   => 'يرجى تعبئة الاسم ووسيلة تواصل واحدة على الأقل.',
				'whatsapp_t' => 'واتساب',
				'hours_t'    => 'أوقات العمل',
				'hours'      => 'الأحد – الخميس، 10 صباحاً – 6 مساءً (بتوقيت الرياض)',
				'privacy'    => 'نستخدم بياناتك للرد على طلبك فقط.',
			),
			'company'   => array(
				'back'     => 'كل الشركات',
				'features' => 'ماذا تقدّم',
				'family'   => 'تعمل مع بقية العائلة',
				'visit'    => 'زيارة',
				'talk'     => 'تحدّث معنا',
			),
			'footer'    => array(
				'tagline'   => 'الشركة الأم لـ KePixel وKeMarq وKeChat وKeClinic.',
				'companies' => 'الشركات',
				'pages'     => 'الصفحات',
				'contact'   => 'التواصل',
				'rights'    => 'جميع الحقوق محفوظة.',
				'made'      => 'صُنع بعناية في الرياض والقاهرة.',
			),
			'notfound'  => array(
				'title' => 'هذه الصفحة خارج العائلة',
				'sub'   => 'الرابط غير موجود أو تم نقله.',
				'btn'   => 'العودة للرئيسية',
			),
		),

		'en' => array(
			'meta'      => array(
				'title'       => 'KeFamily — The parent company of KePixel, KeMarq, KeChat & KeClinic',
				'description' => 'KeFamily unites KePixel, KeMarq, KeChat & KeClinic: performance marketing, server-side tracking, WhatsApp automation and clinic growth.',
			),
			'nav'       => array(
				'home'      => 'Home',
				'companies' => 'Companies',
				'ecosystem' => 'How it works',
				'about'     => 'About',
				'contact'   => 'Contact',
				'cta'       => 'Start a project',
				'menu'      => 'Menu',
				'close'     => 'Close',
				'switch'    => 'العربية',
				'skip'      => 'Skip to content',
			),
			'hero'      => array(
				'eyebrow' => 'The parent company of four marketing & tech companies',
				'title_a' => 'One family that',
				'rotate'  => array( 'brings the customer.', 'measures every step.', 'turns chats into sales.', 'runs your clinic.' ),
				'sub'     => 'KeFamily unites KePixel, KeMarq, KeChat and KeClinic under one roof — from the first ad your customer sees to the moment they buy, book, and come back.',
				'cta1'    => 'Explore our companies',
				'cta2'    => 'Talk to us on WhatsApp',
				'scroll'  => 'Scroll',
				'core'    => 'Family',
			),
			'marquee'   => array( 'Server-side tracking', 'Performance ads', 'WhatsApp automation', 'Clinic bookings', 'Meta', 'Snapchat', 'TikTok', 'Google Ads', 'GA4', 'Salla', 'Zid', 'Shopify', 'WordPress', 'Shared inbox', 'Unified reporting', 'AI insights' ),
			'companies' => array(
				'eyebrow' => 'The family',
				'title'   => 'Four companies. One goal: growth you can measure.',
				'sub'     => 'Each company owns one stage of the customer journey — and all of them run on the same data.',
				'visit'   => 'Visit site',
				'more'    => 'Details',
				'soon'    => 'Coming soon',
				'items'   => array(
					'kepixel'  => array(
						'tag'      => 'Server-side tracking platform',
						'headline' => 'Every customer action, a cleaner conversion signal.',
						'desc'     => 'Server-side tracking that sends better data to your ad platforms: deduplication, identity resolution and a full attribution journey — set up in under a minute.',
						'points'   => array( '100% server-side tracking', 'Salla, Zid, Shopify, WordPress & mobile apps', 'Sends to Meta, Snapchat, TikTok, Google Ads & GA4' ),
						'long'     => 'Browsers and ad blockers lose a large share of conversion data, so ad algorithms learn from an incomplete picture. KePixel captures events on the server, cleans and deduplicates them, ties them to a customer identity, and delivers them to every ad platform in the format it understands.',
						'features' => array(
							array( 'Server-side tracking', 'Data that survives browser restrictions and ad blockers.' ),
							array( 'Deduplication', 'Every purchase counted exactly once on every platform.' ),
							array( 'Identity resolution', 'One profile per customer across devices and channels.' ),
							array( 'Attribution journey', 'See which campaign started the journey and which closed it.' ),
							array( 'Revenue & orders', 'Order value reaches each platform to optimise for ROAS.' ),
							array( 'AI insights', 'Plain-language summaries of what changed and what to do next.' ),
						),
					),
					'kemarq'   => array(
						'tag'      => 'Integrated performance agency',
						'headline' => 'One team runs your ads.',
						'desc'     => 'Campaign strategy, content, design, websites and reporting — one team accountable for the result, and one report that shows what happened.',
						'points'   => array( 'Meta, Snapchat, TikTok, Google & X ads', 'Content, photo, video & visual identity', 'Websites, landing pages & SEO' ),
						'long'     => 'Instead of coordinating a designer, a media buyer, a developer and an analyst, KeMarq delivers marketing as one integrated package. Campaigns run on accurate tracking data, creative is built for each platform, and everything is measured in a single report.',
						'features' => array(
							array( 'Paid ads', 'Meta, Snapchat, TikTok, Google & X, managed daily.' ),
							array( 'Social media', 'Content plans, publishing and community management.' ),
							array( 'Content & production', 'Photo, video and content made to sell.' ),
							array( 'Design & identity', 'Complete visual identity and ad creative.' ),
							array( 'Websites & landing pages', 'Fast pages built to convert visitors into customers.' ),
							array( 'Tracking, reporting & SEO', 'Pixel, Conversions API, GA4 and search optimisation.' ),
						),
					),
					'kechat'   => array(
						'tag'      => 'WhatsApp platform for business',
						'headline' => 'Turn WhatsApp into your best sales channel.',
						'desc'     => 'Bulk campaigns, a shared team inbox, and automated bookings, reminders and follow-ups — on your own number.',
						'points'   => array( 'Campaigns to opted-in contacts only', 'Shared inbox with team roles', 'Booking reminders, Clinicea integration & API' ),
						'long'     => 'Your customers already live on WhatsApp. KeChat turns your business number into an organised sales channel: your team replies from one inbox, campaigns reach opted-in contacts only, and confirmations and reminders run on their own.',
						'features' => array(
							array( 'Bulk campaigns', 'Messages to segments with a safe daily sending cap.' ),
							array( 'Image templates', 'Reusable templates with name, date and more.' ),
							array( 'Shared inbox', 'Your whole team answers from one number.' ),
							array( 'Automations', 'Booking confirmations, reminders, cancellations and reviews.' ),
							array( 'Contacts', 'Import from Excel or CSV with segments and consent records.' ),
							array( 'API & webhooks', 'Connect it to your systems and your booking tool.' ),
						),
					),
					'keclinic' => array(
						'tag'      => 'Clinic growth solutions',
						'headline' => 'A full calendar, and patients who come back.',
						'desc'     => 'Solutions built for clinics that connect the ad to the booking to the visit — with patient follow-up and ROI measured for every campaign.',
						'points'   => array( 'Automated bookings & reminders', 'Patient follow-up after the visit', 'ROI measured per campaign' ),
						'long'     => 'Clinics lose patients between the ad and the booking, and between the booking and the visit. KeClinic brings the whole family\'s experience into one system for clinics: the campaign brings the patient, the booking is confirmed and reminded automatically, and post-visit follow-up brings them back.',
						'features' => array(
							array( 'Ad to booking', 'Every booking tied to the campaign it came from.' ),
							array( 'Automatic reminders', 'Fewer no-shows with well-timed messages.' ),
							array( 'Patient follow-up', 'Post-visit messages, reviews and re-booking.' ),
							array( 'ROI reporting', 'Know your cost per patient and return per channel.' ),
						),
					),
				),
			),
			'flow'      => array(
				'eyebrow' => 'How it works',
				'title'   => 'One customer journey. Four companies that complete each other.',
				'sub'     => 'Data moves between the companies without getting lost, so every stage improves on what the previous one learned.',
				'hub'     => 'KeFamily',
				'steps'   => array(
					array( 'kemarq', 'We bring the customer', 'Campaigns and creative built on real data.' ),
					array( 'kepixel', 'We measure every step', 'Clean conversion signals that feed the ad algorithms.' ),
					array( 'kechat', 'We convert the chat', 'Replies, reminders and campaigns on WhatsApp.' ),
					array( 'keclinic', 'We bring them back', 'Booking, visit and follow-up that build loyalty.' ),
				),
			),
			'stats'     => array(
				'eyebrow' => 'By the numbers',
				'items'   => array(
					array( 4, '', 'specialised companies under one roof' ),
					array( 8, '', 'data sources supported by KePixel' ),
					array( 7, '', 'ad & analytics platforms connected' ),
					array( 1, ' min', 'or less to set up tracking' ),
				),
			),
			'manifesto' => array(
				'eyebrow' => 'Our philosophy',
				'text'    => 'We don\'t sell separate tools. We build one system where every company completes the one before it, data flows without getting lost, and every riyal spent is measured.',
			),
			'values'    => array(
				'eyebrow' => 'Why KeFamily',
				'title'   => 'What makes us different',
				'items'   => array(
					array( 'data', 'Data first', 'Every decision is built on accurate server-side tracking, not guesswork.' ),
					array( 'link', 'Real integration', 'Our companies are built to work together, not tools stacked on top of each other.' ),
					array( 'chart', 'Measured results', 'One report that shows what was spent and what came back.' ),
					array( 'team', 'One accountable team', 'One partner owns the result, from the first ad to the last message.' ),
				),
			),
			'sectors'   => array(
				'eyebrow' => 'Sectors',
				'title'   => 'We work with businesses that live on returning customers',
				'items'   => array( 'E-commerce', 'Clinics & medical centres', 'Schools & education', 'Non-profits & donation platforms', 'Services & bookings', 'Mobile apps' ),
			),
			'faq'       => array(
				'eyebrow' => 'FAQ',
				'title'   => 'Everything you need to know',
				'items'   => array(
					array( 'What is KeFamily?', 'KeFamily is the parent company of KePixel, KeMarq, KeChat and KeClinic. Each company specialises in one stage of the customer journey, and all of them run on the same data.' ),
					array( 'Do I have to use all the companies together?', 'No. Start with the one you need today and add more later — the integration is ready whenever you are.' ),
					array( 'Which countries do you work in?', 'We serve clients in Saudi Arabia, Egypt and across the Gulf.' ),
					array( 'How do I get started?', 'Message us on WhatsApp or use the contact form, and we\'ll recommend the right company or package for your stage.' ),
				),
			),
			'cta'       => array(
				'title' => 'Ready to build a complete customer journey?',
				'sub'   => 'Tell us about your project and we\'ll suggest where to start inside the family.',
				'btn1'  => 'Contact us',
				'btn2'  => 'WhatsApp us',
			),
			'about'     => array(
				'eyebrow'   => 'About us',
				'title'     => 'We built the family because customers don\'t live in one channel.',
				'sub'       => 'KeFamily is the parent company of a group of companies born from daily work on real campaigns for real clients.',
				'story_t'   => 'Our story',
				'story'     => array(
					'We started by running ad campaigns, and noticed that a large share of conversion data was lost before it reached the ad platforms. So we built KePixel for server-side tracking.',
					'Then we saw customers reaching businesses on WhatsApp, with conversations scattered across phones. So we built KeChat.',
					'Clinics need the ad, the booking and the visit connected more than almost anyone — so KeClinic followed. KeMarq brings it all together as one integrated marketing service.',
					'Today KeFamily unites these companies under one identity and one vision: growth you can measure.',
				),
				'mission_t' => 'Our mission',
				'mission'   => 'To make every riyal and every pound spent on marketing measurable — and to turn every spark of interest into a customer who comes back.',
				'vision_t'  => 'Our vision',
				'vision'    => 'To be the leading technology and marketing partner for growing businesses across the Arab world.',
				'markets_t' => 'Our markets',
				'markets'   => array( 'Saudi Arabia', 'Egypt', 'The Gulf' ),
			),
			'contact'   => array(
				'eyebrow'    => 'Contact',
				'title'      => 'Let\'s talk about your project',
				'sub'        => 'Fill in the form and we\'ll reply within one business day — or message us directly on WhatsApp.',
				'name'       => 'Name',
				'company'    => 'Company',
				'email'      => 'Email',
				'phone'      => 'Phone / WhatsApp',
				'interest'   => 'What do you need?',
				'interests'  => array( 'Not sure — help me choose', 'KePixel — tracking', 'KeMarq — marketing & ads', 'KeChat — WhatsApp', 'KeClinic — clinics' ),
				'message'    => 'Tell us about your project',
				'send'       => 'Send',
				'sending'    => 'Sending…',
				'ok'         => 'Thank you! We received your message and will be in touch soon.',
				'err'        => 'Couldn\'t send. Please try again or message us on WhatsApp.',
				'required'   => 'Please add your name and at least one way to reach you.',
				'whatsapp_t' => 'WhatsApp',
				'hours_t'    => 'Working hours',
				'hours'      => 'Sunday – Thursday, 10 AM – 6 PM (Riyadh time)',
				'privacy'    => 'We only use your details to reply to your request.',
			),
			'company'   => array(
				'back'     => 'All companies',
				'features' => 'What it does',
				'family'   => 'Works with the rest of the family',
				'visit'    => 'Visit',
				'talk'     => 'Talk to us',
			),
			'footer'    => array(
				'tagline'   => 'The parent company of KePixel, KeMarq, KeChat and KeClinic.',
				'companies' => 'Companies',
				'pages'     => 'Pages',
				'contact'   => 'Contact',
				'rights'    => 'All rights reserved.',
				'made'      => 'Crafted with care in Riyadh & Cairo.',
			),
			'notfound'  => array(
				'title' => 'This page left the family',
				'sub'   => 'The link doesn\'t exist or has moved.',
				'btn'   => 'Back to home',
			),
		),
	);

	return $content;
}
