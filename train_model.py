import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
import joblib

# قراءة البيانات
df = pd.read_csv("dataset.csv")

# تحويل gender إلى أرقام
gender_encoder = LabelEncoder()
df["gender"] = gender_encoder.fit_transform(df["gender"])

# تحويل target_track إلى أرقام
target_encoder = LabelEncoder()
df["target_track"] = target_encoder.fit_transform(df["target_track"])

# المدخلات X والمخرجات y
X = df.drop("target_track", axis=1)
y = df["target_track"]

# تقسيم البيانات
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

# إنشاء الموديل
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)
from sklearn.metrics import accuracy_score
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)

# حفظ الموديل والـ encoders
joblib.dump(model, "model.pkl")
joblib.dump(gender_encoder, "gender_encoder.pkl")
joblib.dump(target_encoder, "target_encoder.pkl")

print("Model trained and saved successfully!")
print(f"Model Accuracy: {accuracy * 100:.2f}%")
