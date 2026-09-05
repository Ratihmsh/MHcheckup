import joblib
import os
import sys

script_dir = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(script_dir, 'svm_dass_bundle.joblib')

if not os.path.exists(model_path):
    print(f"Error: {model_path} tidak ditemukan!")
    sys.exit(1)

try:
    print("Loading model...")
    bundle = joblib.load(model_path)
    print("Type of loaded object:", type(bundle))
    
    if isinstance(bundle, dict):
        print("\n=== DETAIL KEYS IN BUNDLE ===")
        
        # 1. Feature columns
        features = bundle.get('feature_cols', [])
        print(f"\n1. feature_cols (Total: {len(features)}):")
        print(features[:10], "... and more" if len(features) > 10 else "")
        
        # 2. Label order
        labels = bundle.get('label_order', [])
        print(f"\n2. label_order:")
        print(labels)
        
        # 3. Targets
        targets = bundle.get('targets', {})
        print(f"\n3. targets (mapping of task scales):")
        for k, v in targets.items():
            print(f"- {k} -> {v}")
            
        # 4. F1 Scores
        f1 = bundle.get('f1_scores', {})
        print(f"\n4. f1_scores (Accuracy/F1 from training):")
        for k, v in f1.items():
            print(f"- {k}: {v}")
            
        # 5. Scalers
        scalers = bundle.get('scalers', {})
        print(f"\n5. scalers (Penskalaan per target):")
        for k, v in scalers.items():
            print(f"- {k}: {type(v)}")
            if hasattr(v, 'mean_'):
                print(f"  Mean (first 5 features): {v.mean_[:5]}")
                print(f"  Var (first 5 features): {v.var_[:5]}")
                
        # 6. Models
        models = bundle.get('models', {})
        print(f"\n6. models (SVM Classifier per target):")
        for k, v in models.items():
            print(f"- {k}: {type(v)}")
            if hasattr(v, 'classes_'):
                print(f"  Classes: {v.classes_}")
                
except Exception as e:
    print("Error inspecting joblib file:", str(e))
