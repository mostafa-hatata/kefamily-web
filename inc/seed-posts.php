<?php
/**
 * Launch articles for the blog (seeded once; editable in wp-admin afterwards).
 * Practical, general guidance only — no invented figures or client claims.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_seed_posts() {
	return array(
		'server-side-tracking-explained' => array(
			'topic' => 'kepixel',
			'date'  => '2026-11-20 10:00:00',
			'langs' => array(
				'en' => array(
					'title'   => 'Server-side tracking, explained without the jargon',
					'excerpt' => 'Why ad platforms miss conversions in the browser, what changes when events are sent from a server, and what to check before you switch.',
					'content' => '<p>Every ad platform optimises toward the conversions it can see. When a purchase, lead or booking never reaches Meta, Google, Snapchat or TikTok, the algorithm learns from an incomplete picture — and spends your budget accordingly.</p>
<h2>Why the browser loses events</h2>
<p>Classic pixels run inside the visitor\'s browser. Ad blockers, privacy settings, short-lived cookies and slow connections all stop some of those requests from ever being sent. The visitor still buys; the platform just never hears about it.</p>
<h2>What server-side tracking changes</h2>
<p>With server-side tracking, the event is captured where the order or booking actually happens — on your server — and sent from there to each platform through its official conversions API. Because the server, not the browser, does the sending, the event is not dropped by browser restrictions.</p>
<h2>Deduplication and identity matter</h2>
<p>Sending more events is only useful if each conversion is counted once. Good setups give every event a unique ID so platforms can deduplicate, and attach consented customer identifiers so the platform can match the conversion to the right person.</p>
<h2>Before you switch, check three things</h2>
<ul><li>Which events matter for your business (purchase, lead, booking) and their values.</li><li>That consent is collected and respected for the data you send.</li><li>That each platform receives the same event names and values, so reports stay comparable.</li></ul>
<p>KePixel was built to do exactly this from a single setup: capture events on the server, deduplicate them, and deliver them to every ad and analytics platform you use.</p>',
				),
				'ar' => array(
					'title'   => 'التتبّع من السيرفر ببساطة ومن غير مصطلحات معقدة',
					'excerpt' => 'لماذا تفقد المنصات الإعلانية جزءاً من التحويلات في المتصفح، وما الذي يتغيّر عند إرسال الأحداث من السيرفر، وما الذي تراجعه قبل الانتقال.',
					'content' => '<p>كل منصة إعلانية تحسّن حملاتها بناءً على التحويلات التي تراها. وعندما لا يصل الشراء أو الطلب أو الحجز إلى Meta أو Google أو Snapchat أو TikTok، تتعلّم الخوارزمية من صورة ناقصة وتصرف ميزانيتك على هذا الأساس.</p>
<h2>لماذا يضيع جزء من الأحداث في المتصفح؟</h2>
<p>البكسل التقليدي يعمل داخل متصفح الزائر. أدوات حظر الإعلانات وإعدادات الخصوصية وملفات تعريف الارتباط قصيرة العمر وبطء الاتصال تمنع بعض هذه الطلبات من الإرسال. الزائر يشتري فعلاً، لكن المنصة لا تعرف.</p>
<h2>ما الذي يغيّره التتبّع من السيرفر؟</h2>
<p>في التتبّع من السيرفر يُلتقط الحدث حيث يحدث الطلب أو الحجز فعلاً — على السيرفر — ثم يُرسل لكل منصة عبر واجهة التحويلات الرسمية الخاصة بها. ولأن السيرفر هو من يرسل وليس المتصفح، لا تُسقط قيود المتصفح هذا الحدث.</p>
<h2>إزالة التكرار وتوحيد الهوية</h2>
<p>إرسال أحداث أكثر مفيد فقط إذا حُسب كل تحويل مرة واحدة. الإعداد الجيد يعطي كل حدث معرّفاً فريداً لتزيل المنصات التكرار، ويرفق بيانات العميل الموافق عليها لتربط المنصة التحويل بالشخص الصحيح.</p>
<h2>قبل الانتقال راجع ثلاثة أشياء</h2>
<ul><li>ما الأحداث المهمة لعملك (شراء، طلب، حجز) وما قيمتها.</li><li>أن الموافقة تُجمع وتُحترم للبيانات التي ترسلها.</li><li>أن كل منصة تستقبل نفس أسماء الأحداث والقيم، لتبقى التقارير قابلة للمقارنة.</li></ul>
<p>بُنيت KePixel لتفعل ذلك من إعداد واحد: التقاط الأحداث من السيرفر، وإزالة المكرر منها، وإرسالها لكل منصة إعلانية وتحليلية تستخدمها.</p>',
				),
				'ru' => array(
					'title'   => 'Серверный трекинг простыми словами',
					'excerpt' => 'Почему рекламные платформы теряют конверсии в браузере, что меняется при отправке событий с сервера и что проверить перед переходом.',
					'content' => '<p>Каждая рекламная платформа оптимизирует кампании по тем конверсиям, которые она видит. Если покупка, заявка или запись не доходит до Meta, Google, Snapchat или TikTok, алгоритм учится на неполной картине — и тратит бюджет соответственно.</p>
<h2>Почему браузер теряет события</h2>
<p>Классические пиксели работают в браузере посетителя. Блокировщики рекламы, настройки приватности, короткоживущие cookie и медленное соединение не дают части запросов уйти. Посетитель покупает, но платформа об этом не узнаёт.</p>
<h2>Что меняет серверный трекинг</h2>
<p>При серверном трекинге событие фиксируется там, где реально происходит заказ или запись, — на вашем сервере — и отправляется в каждую платформу через её официальный API конверсий. Отправляет сервер, а не браузер, поэтому ограничения браузера событие не теряют.</p>
<h2>Дедупликация и идентификация</h2>
<p>Больше событий полезно только тогда, когда каждая конверсия учитывается один раз. Правильная настройка присваивает событию уникальный ID для дедупликации и передаёт идентификаторы клиента, на которые получено согласие, чтобы платформа сопоставила конверсию с нужным человеком.</p>
<h2>Перед переходом проверьте три вещи</h2>
<ul><li>Какие события важны для бизнеса (покупка, заявка, запись) и их ценность.</li><li>Что согласие собирается и соблюдается для передаваемых данных.</li><li>Что все платформы получают одинаковые названия событий и значения, чтобы отчёты были сопоставимы.</li></ul>
<p>KePixel создан именно для этого: события фиксируются на сервере, очищаются от дублей и доставляются во все рекламные и аналитические платформы из одной настройки.</p>',
				),
				'de' => array(
					'title'   => 'Serverseitiges Tracking – einfach erklärt',
					'excerpt' => 'Warum Werbeplattformen im Browser Conversions verlieren, was sich ändert, wenn Events vom Server gesendet werden, und was Sie vor dem Umstieg prüfen sollten.',
					'content' => '<p>Jede Werbeplattform optimiert auf die Conversions, die sie sieht. Erreicht ein Kauf, Lead oder eine Buchung Meta, Google, Snapchat oder TikTok nicht, lernt der Algorithmus aus einem unvollständigen Bild – und setzt Ihr Budget entsprechend ein.</p>
<h2>Warum der Browser Events verliert</h2>
<p>Klassische Pixel laufen im Browser der Besucher. Werbeblocker, Datenschutzeinstellungen, kurzlebige Cookies und langsame Verbindungen verhindern, dass ein Teil der Anfragen gesendet wird. Der Kauf findet statt – die Plattform erfährt nur nichts davon.</p>
<h2>Was serverseitiges Tracking ändert</h2>
<p>Beim serverseitigen Tracking wird das Event dort erfasst, wo Bestellung oder Buchung tatsächlich passieren – auf Ihrem Server – und über die offizielle Conversions-API an jede Plattform übermittelt. Da der Server sendet und nicht der Browser, gehen Events nicht durch Browser-Einschränkungen verloren.</p>
<h2>Deduplizierung und Identität</h2>
<p>Mehr Events helfen nur, wenn jede Conversion genau einmal zählt. Gute Setups geben jedem Event eine eindeutige ID zur Deduplizierung und senden einwilligungsbasierte Kundenmerkmale, damit die Plattform die Conversion der richtigen Person zuordnet.</p>
<h2>Vor dem Umstieg drei Dinge prüfen</h2>
<ul><li>Welche Events für Ihr Geschäft zählen (Kauf, Lead, Buchung) und ihr Wert.</li><li>Dass die Einwilligung für die gesendeten Daten eingeholt und beachtet wird.</li><li>Dass alle Plattformen dieselben Event-Namen und Werte erhalten, damit Berichte vergleichbar bleiben.</li></ul>
<p>KePixel wurde genau dafür gebaut: Events serverseitig erfassen, deduplizieren und mit einer einzigen Einrichtung an alle Werbe- und Analyseplattformen liefern.</p>',
				),
			),
		),

		'whatsapp-campaigns-done-right' => array(
			'topic' => 'kechat',
			'date'  => '2026-11-22 10:00:00',
			'langs' => array(
				'en' => array(
					'title'   => 'WhatsApp campaigns done right: opt-in, segments and pace',
					'excerpt' => 'A practical checklist for sending WhatsApp campaigns customers actually welcome — and that keep your number healthy.',
					'content' => '<p>WhatsApp is where many customers in the Gulf and Egypt already talk to businesses. That makes it powerful — and it is exactly why careless bulk messaging gets numbers reported and restricted.</p>
<h2>1. Message only people who opted in</h2>
<p>Keep a clear record of who agreed to hear from you, when and how. A booking form checkbox or a customer who messaged you first are good starting points. Buying lists is not.</p>
<h2>2. Segment before you send</h2>
<p>A returning customer, a lead who never booked and a patient due for a follow-up need different messages. Smaller, relevant segments get replies; broad blasts get blocked.</p>
<h2>3. Pace your sending</h2>
<p>Use a sensible daily cap and spread messages over time. Sudden spikes from one number look like spam to recipients and to WhatsApp.</p>
<h2>4. Personalise with real fields</h2>
<p>Use the customer\'s name, the service they asked about or their appointment date. Reusable templates with personal fields save time without sounding robotic.</p>
<h2>5. Make replying easy — and answer</h2>
<p>A campaign is the start of a conversation. A shared team inbox means replies are picked up quickly, even when several people handle the same number.</p>
<p>KeChat brings these pieces together: opted-in contacts and segments, a daily sending cap, image templates with personal fields, automations for bookings and reminders, and a shared inbox for your team.</p>',
				),
				'ar' => array(
					'title'   => 'حملات واتساب بالطريقة الصحيحة: الموافقة، الشرائح، والإيقاع',
					'excerpt' => 'قائمة عملية لإرسال حملات واتساب يرحّب بها العملاء فعلاً — وتحافظ على سلامة رقمك.',
					'content' => '<p>واتساب هو المكان الذي يتواصل فيه كثير من العملاء في الخليج ومصر مع الشركات. وهذا ما يجعله قوياً — وهو أيضاً سبب الإبلاغ عن الأرقام وتقييدها عند الإرسال العشوائي.</p>
<h2>1. راسل فقط من وافق</h2>
<p>احتفظ بسجل واضح لمن وافق على تلقي رسائلك، ومتى وكيف. خانة موافقة في نموذج الحجز، أو عميل راسلك أولاً، بداية جيدة. أما شراء القوائم فلا.</p>
<h2>2. قسّم قبل أن ترسل</h2>
<p>العميل العائد، والعميل المحتمل الذي لم يحجز، والمريض الذي حان موعد متابعته، يحتاج كل منهم رسالة مختلفة. الشرائح الأصغر والأدق تحصل على ردود، والرسائل العامة تُحظر.</p>
<h2>3. حافظ على إيقاع الإرسال</h2>
<p>استخدم حداً يومياً معقولاً ووزّع الرسائل على الوقت. الارتفاع المفاجئ من رقم واحد يبدو رسائل مزعجة للمستلمين ولواتساب.</p>
<h2>4. خصّص الرسالة ببيانات حقيقية</h2>
<p>استخدم اسم العميل، والخدمة التي سأل عنها، أو تاريخ موعده. القوالب القابلة لإعادة الاستخدام مع الحقول الشخصية توفر الوقت دون أن تبدو آلية.</p>
<h2>5. سهّل الرد — ثم رُد</h2>
<p>الحملة بداية محادثة. صندوق الوارد المشترك يضمن التقاط الردود بسرعة حتى لو كان أكثر من شخص يدير نفس الرقم.</p>
<p>KeChat تجمع كل ذلك: جهات اتصال موافقة وشرائح، حد إرسال يومي، قوالب بالصور مع حقول شخصية، أتمتة للحجوزات والتذكيرات، وصندوق وارد مشترك لفريقك.</p>',
				),
				'ru' => array(
					'title'   => 'Рассылки в WhatsApp без ошибок: согласие, сегменты и темп',
					'excerpt' => 'Практический чек-лист для рассылок в WhatsApp, которые клиенты действительно ждут, — и которые не вредят вашему номеру.',
					'content' => '<p>Многие клиенты в странах Персидского залива и в Египте уже общаются с компаниями в WhatsApp. Поэтому канал так силён — и поэтому небрежные массовые рассылки приводят к жалобам и ограничениям номера.</p>
<h2>1. Пишите только тем, кто дал согласие</h2>
<p>Храните понятную запись о том, кто согласился получать сообщения, когда и каким образом. Галочка в форме записи или клиент, который написал первым, — хорошая основа. Купленные базы — нет.</p>
<h2>2. Сегментируйте перед отправкой</h2>
<p>Постоянному клиенту, лиду без записи и пациенту, которому пора на контроль, нужны разные сообщения. Небольшие релевантные сегменты получают ответы, широкие рассылки — блокировки.</p>
<h2>3. Соблюдайте темп</h2>
<p>Используйте разумный дневной лимит и распределяйте отправку во времени. Резкие всплески с одного номера выглядят как спам и для получателей, и для WhatsApp.</p>
<h2>4. Персонализируйте реальными данными</h2>
<p>Имя клиента, интересующая услуга или дата визита. Шаблоны с персональными полями экономят время и не звучат механически.</p>
<h2>5. Упростите ответ — и отвечайте</h2>
<p>Рассылка — это начало диалога. Общий входящий ящик позволяет быстро подхватывать ответы, даже если номер ведут несколько сотрудников.</p>
<p>KeChat объединяет всё это: контакты с согласием и сегменты, дневной лимит отправки, шаблоны с картинками и персональными полями, автоматизацию записей и напоминаний и общий ящик для команды.</p>',
				),
				'de' => array(
					'title'   => 'WhatsApp-Kampagnen richtig gemacht: Opt-in, Segmente, Tempo',
					'excerpt' => 'Eine praktische Checkliste für WhatsApp-Kampagnen, die Kunden wirklich begrüßen – und die Ihre Nummer gesund halten.',
					'content' => '<p>In der Golfregion und in Ägypten sprechen viele Kunden bereits über WhatsApp mit Unternehmen. Das macht den Kanal stark – und genau deshalb führen unbedachte Massennachrichten zu Meldungen und Einschränkungen der Nummer.</p>
<h2>1. Nur Kontakte mit Einwilligung anschreiben</h2>
<p>Dokumentieren Sie, wer wann und wie zugestimmt hat. Ein Häkchen im Buchungsformular oder ein Kunde, der zuerst geschrieben hat, sind ein guter Anfang. Gekaufte Listen nicht.</p>
<h2>2. Vor dem Senden segmentieren</h2>
<p>Stammkunden, Leads ohne Buchung und Patienten mit fälliger Nachsorge brauchen unterschiedliche Nachrichten. Kleine, relevante Segmente bekommen Antworten; breite Aussendungen werden blockiert.</p>
<h2>3. Das Tempo kontrollieren</h2>
<p>Nutzen Sie ein sinnvolles Tageslimit und verteilen Sie die Nachrichten. Plötzliche Spitzen von einer Nummer wirken auf Empfänger und WhatsApp wie Spam.</p>
<h2>4. Mit echten Feldern personalisieren</h2>
<p>Name, angefragte Leistung oder Termindatum. Wiederverwendbare Vorlagen mit persönlichen Feldern sparen Zeit, ohne mechanisch zu klingen.</p>
<h2>5. Antworten leicht machen – und antworten</h2>
<p>Eine Kampagne ist der Beginn eines Gesprächs. Ein gemeinsamer Team-Posteingang sorgt dafür, dass Antworten schnell bearbeitet werden, auch wenn mehrere Personen dieselbe Nummer betreuen.</p>
<p>KeChat bündelt all das: Kontakte mit Einwilligung und Segmente, ein tägliches Versandlimit, Bildvorlagen mit persönlichen Feldern, Automationen für Buchungen und Erinnerungen sowie einen gemeinsamen Posteingang.</p>',
				),
			),
		),

		'reduce-clinic-no-shows' => array(
			'topic' => 'keclinic',
			'date'  => '2026-11-24 10:00:00',
			'langs' => array(
				'en' => array(
					'title'   => 'Fewer no-shows: a simple reminder plan for clinics',
					'excerpt' => 'Confirm, remind, make rescheduling easy and follow up — a four-step routine that protects your calendar.',
					'content' => '<p>A missed appointment costs a clinic twice: the empty slot, and the marketing spent to fill it. Most no-shows are not decisions — they are forgotten appointments or plans that changed without an easy way to say so.</p>
<h2>1. Confirm immediately</h2>
<p>Send a confirmation the moment the booking is made, with the date, time, branch and doctor. A clear confirmation turns a form submission into a commitment.</p>
<h2>2. Remind at the right moments</h2>
<p>One reminder the day before and one a short time before the visit cover most cases. Send them on the channel patients actually read — for many, that is WhatsApp.</p>
<h2>3. Make rescheduling one tap away</h2>
<p>A patient who can easily move an appointment will usually move it instead of skipping it. Every reminder should include a simple way to confirm, reschedule or cancel.</p>
<h2>4. Follow up after the visit</h2>
<p>Ask how the visit went, request a review and suggest the next appointment when it is due. Returning patients are the most reliable way to keep a calendar full.</p>
<h2>Measure it</h2>
<p>Track bookings, attended visits and no-shows per campaign and per channel. Knowing which campaigns bring patients who actually attend is more useful than counting bookings alone.</p>
<p>KeClinic connects these steps — from the campaign that brings the patient, through confirmations and reminders, to follow-up and reporting.</p>',
				),
				'ar' => array(
					'title'   => 'غياب أقل عن المواعيد: خطة تذكير بسيطة للعيادات',
					'excerpt' => 'أكّد، ذكّر، سهّل تغيير الموعد، ثم تابع — روتين من أربع خطوات يحمي جدول عيادتك.',
					'content' => '<p>الموعد الفائت يكلّف العيادة مرتين: الموعد الفارغ، والتسويق الذي صُرف لملئه. معظم حالات الغياب ليست قراراً، بل موعد منسي أو خطة تغيّرت دون طريقة سهلة للإبلاغ.</p>
<h2>1. أكّد الحجز فوراً</h2>
<p>أرسل تأكيداً لحظة الحجز يتضمن التاريخ والوقت والفرع والطبيب. التأكيد الواضح يحوّل تعبئة النموذج إلى التزام.</p>
<h2>2. ذكّر في التوقيت المناسب</h2>
<p>تذكير قبل الموعد بيوم وآخر قبله بوقت قصير يغطيان معظم الحالات. أرسلهما عبر القناة التي يقرأها المرضى فعلاً — وهي لكثير منهم واتساب.</p>
<h2>3. اجعل تغيير الموعد بلمسة واحدة</h2>
<p>المريض الذي يستطيع تغيير موعده بسهولة يغيّره غالباً بدلاً من أن يتغيّب. يجب أن يتضمن كل تذكير طريقة بسيطة للتأكيد أو التغيير أو الإلغاء.</p>
<h2>4. تابع بعد الزيارة</h2>
<p>اسأل عن تجربة الزيارة، واطلب تقييماً، واقترح الموعد التالي عند حلوله. المرضى العائدون هم أكثر طريقة موثوقة لإبقاء الجدول ممتلئاً.</p>
<h2>قِس النتيجة</h2>
<p>تتبّع الحجوزات والزيارات الفعلية والغياب لكل حملة ولكل قناة. معرفة الحملات التي تجلب مرضى يحضرون فعلاً أهم من عدّ الحجوزات وحدها.</p>
<p>KeClinic تربط هذه الخطوات — من الحملة التي تجلب المريض، مروراً بالتأكيد والتذكير، وحتى المتابعة والتقارير.</p>',
				),
				'ru' => array(
					'title'   => 'Меньше неявок: простой план напоминаний для клиник',
					'excerpt' => 'Подтвердить, напомнить, упростить перенос и связаться после визита — четыре шага, которые защищают расписание.',
					'content' => '<p>Пропущенный приём обходится клинике дважды: пустое окно и маркетинг, потраченный на то, чтобы его заполнить. Большинство неявок — не решение, а забытая запись или изменившиеся планы без удобного способа об этом сообщить.</p>
<h2>1. Подтверждайте сразу</h2>
<p>Отправляйте подтверждение в момент записи: дата, время, филиал и врач. Чёткое подтверждение превращает заполненную форму в обязательство.</p>
<h2>2. Напоминайте вовремя</h2>
<p>Одно напоминание за день и одно незадолго до визита покрывают большинство случаев. Отправляйте их туда, где пациенты действительно читают сообщения, — для многих это WhatsApp.</p>
<h2>3. Перенос — в одно касание</h2>
<p>Пациент, который может легко перенести приём, чаще переносит, чем пропускает. В каждом напоминании должен быть простой способ подтвердить, перенести или отменить визит.</p>
<h2>4. Свяжитесь после визита</h2>
<p>Спросите о впечатлениях, попросите отзыв и предложите следующий приём, когда он нужен. Возвращающиеся пациенты — самый надёжный способ держать расписание заполненным.</p>
<h2>Измеряйте результат</h2>
<p>Отслеживайте записи, состоявшиеся визиты и неявки по каждой кампании и каналу. Важнее знать, какие кампании приводят пациентов, которые действительно приходят, чем просто считать записи.</p>
<p>KeClinic связывает эти шаги — от кампании, которая приводит пациента, через подтверждения и напоминания до повторного контакта и отчётов.</p>',
				),
				'de' => array(
					'title'   => 'Weniger Terminausfälle: ein einfacher Erinnerungsplan für Praxen',
					'excerpt' => 'Bestätigen, erinnern, Umbuchen leicht machen, nachfassen – eine Routine in vier Schritten, die Ihren Kalender schützt.',
					'content' => '<p>Ein verpasster Termin kostet eine Praxis doppelt: den leeren Slot und das Marketing, das ihn füllen sollte. Die meisten Ausfälle sind keine Entscheidung, sondern vergessene Termine oder geänderte Pläne ohne einfache Möglichkeit, Bescheid zu geben.</p>
<h2>1. Sofort bestätigen</h2>
<p>Senden Sie direkt bei der Buchung eine Bestätigung mit Datum, Uhrzeit, Standort und Ärztin oder Arzt. Eine klare Bestätigung macht aus einem Formular eine Zusage.</p>
<h2>2. Im richtigen Moment erinnern</h2>
<p>Eine Erinnerung am Vortag und eine kurz vor dem Termin decken die meisten Fälle ab. Senden Sie sie über den Kanal, den Patienten wirklich lesen – für viele ist das WhatsApp.</p>
<h2>3. Umbuchen mit einem Tipp</h2>
<p>Wer einen Termin leicht verschieben kann, verschiebt ihn meist, statt fernzubleiben. Jede Erinnerung sollte eine einfache Möglichkeit zum Bestätigen, Verschieben oder Absagen enthalten.</p>
<h2>4. Nach dem Besuch nachfassen</h2>
<p>Fragen Sie nach dem Besuch, bitten Sie um eine Bewertung und schlagen Sie den nächsten fälligen Termin vor. Wiederkehrende Patienten halten den Kalender am zuverlässigsten voll.</p>
<h2>Messen</h2>
<p>Erfassen Sie Buchungen, wahrgenommene Termine und Ausfälle pro Kampagne und Kanal. Zu wissen, welche Kampagnen Patienten bringen, die tatsächlich erscheinen, ist wertvoller als reine Buchungszahlen.</p>
<p>KeClinic verbindet diese Schritte – von der Kampagne, die den Patienten bringt, über Bestätigung und Erinnerung bis zu Nachsorge und Reporting.</p>',
				),
			),
		),
	);
}
