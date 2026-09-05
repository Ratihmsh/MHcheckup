import warnings
warnings.filterwarnings("ignore")

import joblib
import sys
import json
import numpy as np
import os

def main():
    # Menggunakan path absolut relatif terhadap folder script ini
    script_dir = os.path.dirname(os.path.abspath(__file__))
    model_path = os.path.join(script_dir, 'svm_dass_bundle.joblib')

    if not os.path.exists(model_path):
        print(json.dumps({"error": f"Model file not found at {model_path}"}))
        sys.exit(1)

    if len(sys.argv) < 2:
        print(json.dumps({"error": "No answers input provided. Use comma-separated list of 42 answers."}))
        sys.exit(1)

    raw_input = sys.argv[1]
    try:
        answers = [int(x.strip()) for x in raw_input.split(',')]
    except ValueError:
        print(json.dumps({"error": "Answers must be integers separated by commas."}))
        sys.exit(1)

    if len(answers) != 42:
        print(json.dumps({"error": f"Must provide exactly 42 answers. Got {len(answers)}."}))
        sys.exit(1)

    try:
        bundle = joblib.load(model_path)
        
        # Reshape menjadi shape (1, 42) untuk diumpankan ke scikit-learn
        X_new = np.array(answers).reshape(1, -1)
        
        predictions = {}
        for scale in ['Depresi', 'Kecemasan', 'Stres']:
            scaler = bundle['scalers'][scale]
            model = bundle['models'][scale]
            
            # Normalisasi data masukan
            X_scaled = scaler.transform(X_new)
            
            # Prediksi kategori
            pred_label = model.predict(X_scaled)[0]
            predictions[scale] = pred_label

        print(json.dumps(predictions))
        
    except Exception as e:
        print(json.dumps({"error": f"Prediction error: {str(e)}"}))
        sys.exit(1)

if __name__ == "__main__":
    main()
