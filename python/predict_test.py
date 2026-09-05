import joblib
import sys
import json
import numpy as np

import os

try:
    script_dir = os.path.dirname(os.path.abspath(__file__))
    model_path = os.path.join(script_dir, 'svm_dass_bundle.joblib')
    bundle = joblib.load(model_path)
    
    # Mock input: 42 answers
    # Budi Santoso's mock answers (Stres Tinggi, Depresi Ringan, Kecemasan Sedang)
    # Soal Stres: 1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39 -> 2
    # Soal Depresi: 3, 5, 10, 13, 16 -> 1
    # Soal Kecemasan: 2, 4, 7, 9, 15, 19, 20, 23 -> 2
    # Others -> 1 or 0
    answers = [1] * 42
    # Adjust mock answers based on 1-indexed questions (so index - 1)
    for q in [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39]:
        answers[q-1] = 2
    for q in [3, 5, 10, 13, 16]:
        answers[q-1] = 1
    for q in [2, 4, 7, 9, 15, 19, 20, 23]:
        answers[q-1] = 2
        
    X_new = np.array(answers).reshape(1, -1)
    
    predictions = {}
    for scale in ['Depresi', 'Kecemasan', 'Stres']:
        scaler = bundle['scalers'][scale]
        model = bundle['models'][scale]
        
        # Scale
        X_scaled = scaler.transform(X_new)
        # Predict
        pred = model.predict(X_scaled)[0]
        predictions[scale] = pred
        
    print("Predictions for Budi Santoso mock answers:")
    print(json.dumps(predictions, indent=2))
    
except Exception as e:
    print("Error during test prediction:", str(e))
