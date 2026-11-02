<?php
session_start();
// إعادة الاختبار: نمسح الإجابات فقط ونحافظ على النسبة والمسار
unset($_SESSION['answers']);
header("Location: quiz.php");
exit();
?>