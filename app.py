from flask import Flask, request, jsonify
import joblib
import pandas as pd
app = Flask(__name__)

# تحميل الموديل والـ encoders
model = joblib.load("model.pkl")
gender_encoder = joblib.load("gender_encoder.pkl")
target_encoder = joblib.load("target_encoder.pkl")

@app.route("/predict", methods=["POST"])
def predict():
    data = request.json

    school = float(data["school"])
    qudrat = float(data["qudrat"])
    tahsili = float(data["tahsili"])
    gender = data["gender"]

    q1 = int(data["q1"])
    q2 = int(data["q2"])
    q3 = int(data["q3"])
    q4 = int(data["q4"])
    q5 = int(data["q5"])
    q6 = int(data["q6"])
    q7 = int(data["q7"])
    q8 = int(data["q8"])
    q9 = int(data["q9"])
    q10 = int(data["q10"])

    # تحويل gender
    gender_encoded = gender_encoder.transform([gender])[0]

    # تجهيز البيانات
    input_data = pd.DataFrame([{
        "school": school,
        "qudrat": qudrat,
        "tahsili": tahsili,
        "gender": gender_encoded,
        "q1": q1,
        "q2": q2,
        "q3": q3,
        "q4": q4,
        "q5": q5,
        "q6": q6,
        "q7": q7,
        "q8": q8,
        "q9": q9,
        "q10": q10
    }])

    # التنبؤ
    prediction = model.predict(input_data)[0]
    predicted_track = target_encoder.inverse_transform([prediction])[0]

    return jsonify({
        "predicted_track": predicted_track
    })

if __name__ == "__main__":
    app.run(debug=True)