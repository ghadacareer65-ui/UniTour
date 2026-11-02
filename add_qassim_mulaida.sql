-- 1) جامعة القصيم - المليداء (طلاب وطالبات)
INSERT INTO universities (id, name_ar, name_en, city_ar, city_en, gender_allowed, logo_url) VALUES
(5, 'جامعة القصيم - المليداء', 'Qassim University - Al-Mulaida', 'المليداء', 'Al-Mulaida', 'both', 'images/qu.png');

-- 2) الجولات الافتراضية
INSERT INTO virtual_tours (university_id, tour_type, tour_url) VALUES
(5, 'custom', 'https://www.qu.edu.sa/');
-- فرع عنيزة يفتح جولتك المكتوبة بـ PHP
UPDATE virtual_tours SET tour_url = 'tour_unaizah.php' WHERE university_id = 1;

-- 3) تخصصات المليداء (راجعيها مع موقع الجامعة)
INSERT INTO majors (university_id, name_ar, name_en, category) VALUES
(5, 'إدارة أعمال', 'Business Administration', 'إداري'),
(5, 'محاسبة', 'Accounting', 'إداري'),
(5, 'تسويق', 'Marketing', 'إداري'),
(5, 'شريعة', 'Sharia', 'شرعي'),
(5, 'أصول الدين', 'Fundamentals of Religion', 'شرعي'),
(5, 'دراسات إسلامية', 'Islamic Studies', 'شرعي'),
(5, 'طب', 'Medicine', 'صحة وحياة'),
(5, 'صيدلة', 'Pharmacy', 'صحة وحياة'),
(5, 'تمريض', 'Nursing', 'صحة وحياة'),
(5, 'علوم طبية تطبيقية', 'Applied Medical Sciences', 'صحة وحياة'),
(5, 'علوم الحاسب', 'Computer Science', 'هندسة حاسب'),
(5, 'تقنية المعلومات', 'Information Technology', 'هندسة حاسب'),
(5, 'نظم المعلومات', 'Information Systems', 'هندسة حاسب'),
(5, 'لغة عربية', 'Arabic Language', 'عام'),
(5, 'لغة إنجليزية', 'English Language', 'عام'),
(5, 'تاريخ', 'History', 'عام');
