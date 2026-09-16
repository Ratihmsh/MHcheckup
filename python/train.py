import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.svm import SVC
from sklearn.metrics import classification_report, f1_score
import joblib
import os

def main():
    # 1. Konfigurasi Path Lokal
    # Mendapatkan path folder tempat script ini berada (c:\laragon\www\dass-app\python)
    script_dir = os.path.dirname(os.path.abspath(__file__))
    
    # Pastikan Anda memindahkan file excel dataset ke dalam folder python/ ini
    DATA_PATH = os.path.join(script_dir, "dataset_fiks_dass.xlsx")
    MODEL_OUTPUT_PATH = os.path.join(script_dir, "svm_dass_bundle.joblib")
    
    RANDOM_STATE = 42
    TEST_SIZE = 0.30

    FEATURE_COLS = [f"Q{i}" for i in range(1, 43)]
    TARGETS = {
        "Depresi": "category_depression",
        "Kecemasan": "category_anxiety",
        "Stres": "category_stress",
    }
    LABEL_ORDER = ["Normal", "Ringan", "Sedang", "Parah", "Sangat Parah"]

    # 2. Load data
    print(f"Membaca dataset dari: {DATA_PATH}")
    if not os.path.exists(DATA_PATH):
        print(f"\nERROR: File dataset tidak ditemukan!\nPastikan Anda sudah mencopy file 'dataset_fiks_dass.xlsx' ke folder:\n{script_dir}")
        return

    df = pd.read_excel(DATA_PATH, sheet_name="ALL")
    print(f"Total data: {len(df)} responden\n")

    # 3. Training & Evaluasi
    idx_train, idx_test = train_test_split(
        df.index, test_size=TEST_SIZE, random_state=RANDOM_STATE
    )
    
    models, scalers, reports = {}, {}, {}

    for label, target_col in TARGETS.items():
        print("=" * 70)
        print(f"MELATIH MODEL SVM UNTUK TARGET: {label}")
        print("=" * 70)

        X_train = df.loc[idx_train, FEATURE_COLS].values
        y_train = df.loc[idx_train, target_col].values
        X_test = df.loc[idx_test, FEATURE_COLS].values
        y_test = df.loc[idx_test, target_col].values

        scaler = StandardScaler().fit(X_train)
        X_train_s = scaler.transform(X_train)
        X_test_s = scaler.transform(X_test)

        model = SVC(
            kernel="rbf", C=1.0, gamma="scale",
            decision_function_shape="ovr",
            probability=True,
            random_state=RANDOM_STATE,
        )
        model.fit(X_train_s, y_train)

        y_pred = model.predict(X_test_s)
        f1 = f1_score(y_test, y_pred, average="weighted", zero_division=0)

        print(classification_report(y_test, y_pred, labels=LABEL_ORDER, zero_division=0))
        print(f"F1 score: {f1:.3f}\n")

        models[label] = model
        scalers[label] = scaler
        reports[label] = f1

    print("=" * 70)
    print("RINGKASAN F1 SCORE KETIGA MODEL")
    print("=" * 70)
    for label, f1 in reports.items():
        print(f"{label:12s}: F1 = {f1:.3f}")

    # 4. Simpan Model
    bundle = {
        "models": models,
        "scalers": scalers,
        "feature_cols": FEATURE_COLS,
        "label_order": LABEL_ORDER,
        "targets": TARGETS,
        "f1_scores": reports,
    }
    joblib.dump(bundle, MODEL_OUTPUT_PATH)
    print(f"\nModel berhasil di-training dan disimpan di:\n{MODEL_OUTPUT_PATH}")

if __name__ == "__main__":
    main()
