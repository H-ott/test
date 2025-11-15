### 1. 
![image](https://hackmd.io/_uploads/SkhRBBzlbe.png)

Sơ đồ mã hoá thuật toán Feistel:
![image](https://hackmd.io/_uploads/BJBqIrGgZe.png)


Code:
```c++
#include <bits/stdc++.h>
using namespace std;

char F(char Ri, char Ki) {
	return Ri + Ki;
}

int main () {
	string P, C = "xx";
	char L[3], R[3], k;
	cin >> P;
	char K[3];
	cin >> k;
	K[0] = k;
	L[0] = P[0], R[0] = P[1];
	for (int i = 1; i <= 2; i++) {
		K[i] = K[0] << i;
		R[i] = L[i-1] ^ F(R[i-1], K[i]);
		L[i] = R[i-1];
	}
	C[0] = R[2]; C[1] = L[2];
	cout << C << endl;
	
	for (int i = 2; i >= 1; i--) {
		K[i] = K[0] << i;
		L[i-1] = R[i] ^ F(L[i], K[i]);
		R[i-1] = L[i];
	}
	P[0] = L[0];
	P[1] = R[0];
	cout << P;
	return 0;
}
```
### 2. Đề bài giống bài 1 ở trên nhưng lặp lại 3 lần (3DES)

Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

char F(char R, char K) {
	return R + K;
}

string EDes(string P, char k) {
	string C = "xx";
	char K[3], L[3], R[3];
	K[0] = k;
	L[0] = P[0], R[0] = P[1];
	for (int i = 1; i <= 2; i++) {
		K[i] = K[0] << i;
		R[i] = L[i-1] ^ F(R[i-1], K[i]);
		L[i] = R[i-1];
	}
	C[0] = R[2]; C[1] = L[2];
	return C;
}

string DDes(string C, char k) {
	string P = "xx";
	char K[3], L[3], R[3];
	K[0] = k;
	L[2] = C[1]; R[2] = C[0];
	for (int i = 2; i >= 1; i--) {
		K[i] = K[0] << i;
		L[i-1] = R[i] ^ F(L[i], K[i]);
		R[i-1] = L[i];
	}
	P[0] = L[0]; P[1] = R[0];
	
	return P;
}

int main () {
	
	string P, c;
	char k;
	cin >> P >> k;
	c = EDes(P, k);
	for (int i = 1; i <= 2; i++) {
		c = EDes(c, k);
	}
	cout << c << endl;
	P = DDes(c, k);
	for (int i = 1; i <= 2; i++) {
		P = DDes(P, k);
	}
	cout << P;
	
	return 0;
}
```

### 3. 

![image](https://hackmd.io/_uploads/SJnrJ8ze-e.png)
Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

char F(char R, char K) {
	return R + K;
}

string EDes(string P, char k) {
	string C = "xx";
	char K[3], L[3], R[3];
	K[0] = k;
	L[0] = P[0], R[0] = P[1];
	for (int i = 1; i <= 2; i++) {
		K[i] = K[0] << i;
		R[i] = L[i-1] ^ F(R[i-1], K[i]);
		L[i] = R[i-1];
	}
	C[0] = R[2]; C[1] = L[2];
	return C;
}

string DDes(string C, char k) {
	string P = "xx";
	char K[3], L[3], R[3];
	K[0] = k;
	L[2] = C[1]; R[2] = C[0];
	for (int i = 2; i >= 1; i--) {
		K[i] = K[0] << i;
		L[i-1] = R[i] ^ F(L[i], K[i]);
		R[i-1] = L[i];
	}
	P[0] = L[0]; P[1] = R[0];
	
	return P;
}

int main () {
	
	string P, C = "";
	char K;
	getline(cin, P);	
	cin >> K;
	if ((int)P.length() % 2 != 0) {
		P += '#';
	}
		for (int i = 0; i < P.length(); i++) {
//			cout << P[i] << " " << P[i+1] << endl;
			string tmp1 = {P[i]}, tmp2 = {P[i+1]};
			string tmp = tmp1 + tmp2;
//			cout << tmp << " ";
			string c = EDes(tmp, K);
			P[i] = c[0]; P[i+1] = c[1];
			C += c;
			i++;
		}
	cout << C << endl;
	P = "";
	int i = C.length() - 1;
	while (i >= 0) {
		string tmp1 = {C[i-1]}, tmp2 = {C[i]};
		string tmp = tmp1 + tmp2;
		string p = DDes(tmp, K);
		P = p + P;
		i -= 2;
	}
	cout << P;
	return 0;
}
```

### 4. 
![image](https://hackmd.io/_uploads/BJ3FPrGxbx.png)

Code: 
```c++
#include <bits/stdc++.h>
using namespace std;


int main () {
	
	string P, K;
	char T[256], S[256];
	getline(cin, P);
	getline(cin, K);
	// ma hoa
	for (int i = 0; i <= 255; i++) {
		T[i] = K[i % K.size()];
		S[i] = i;
	}
	
	int j = 0;
	for (int i = 0; i <= 255; i++) {
		j = (j + S[i] + T[i]) % 256;
		int tmp = S[i];
		S[i] = S[j];
		S[j] = tmp;
	}
	
	int i = 0;
	j = 0;

	for (int x = 0; x < P.size(); x++) {
		i = (i + 1) % 256;
		j = (j + S[i]) % 256;
		swap(S[i], S[j]);
		int t = (S[i] + S[j]) % 256;
		int k = S[t];
		P[x] = P[x] ^ k;
	}
	cout << P << endl;
	
	// giai ma lap lai code o tren=))
	
	for (int i = 0; i <= 255; i++) {
		T[i] = K[i % K.size()];
		S[i] = i;
	}
	j = 0;
	for (int i = 0; i <= 255; i++) {
		j = (j + S[i] + T[i]) % 256;
		int tmp = S[i];
		S[i] = S[j];
		S[j] = tmp;
	}
	i = 0;
	j = 0;
	for (int x = 0; x < P.size(); x++) {
		i = (i + 1) % 256;
		j = (j + S[i]) % 256;
		swap(S[i], S[j]);
		int t = (S[i] + S[j]) % 256;
		int k = S[t];
		P[x] = P[x] ^ k;
	}
	cout << P << endl;
	
	return 0;
}
```

### 5. 
![image](https://hackmd.io/_uploads/SkpNdSGxWg.png)

Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int main () {
	
	int p; cin >> p;
	
	for (int i = 1; i < p; i++) {
//		bool kt = true;
		cout << i << " ";
		for (int j = 2; j <p; j++) {
			cout << mu(i, j, p) << " ";
		}
		cout << endl;
	}
	
	return 0;
}
```

### 6. 
![image](https://hackmd.io/_uploads/HkT4ZLMeWl.png)

Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int main () {

	int p; cin >> p;
	
	for (int i = 2; i < p; i++) {
		bool kt = true;
		for (int j = 2; j < p; j++) {
			if (mu(i, j, p) == i) {
				kt = false;
				break;
			}
		}
		if (kt == true) cout << i << " ";
	}
	
	return 0;
}
```


### 7. Lập trình tính số điểm có trên đường cong Ep(a,b), với a, b, p nhập từ bàn phím. Liệt kê các điểm của đường cong đó ra màn hình.
![image](https://hackmd.io/_uploads/BJ6yt7GgZg.png)

Code: 
```c++ 
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int main () {
	
	// pt: y^2 mod 23 = (x^3 + x + 1) mod 23
	int a, b, p; cin >> a >> b >> p;
	
	for (int i = 0; i < p; i++) {
		for (int j = 0; j < p; j++) {
			if ((mu(i, 3, p) + a*i + b)%p - mu(j, 2, p)%p == 0) {
				cout << i << " " << j << endl;
			}
		}
	}
	return 0;
}
```
### 8. P(xP, yP) và Q(xQ, yQ) là 2 điểm khác nhau thuộc Ep(a,b). Lập trình nhập tọa độ 2 điểm rồi tính tổng 2 điểm đó, với p nhập từ bàn phím, sau đó lấy điểm vừa tính được trừ đi 1 trong 2 điểm ban đầu rồi kiểm tra xem có bằng 1 trong 2 điểm còn lại hay không?
![image](https://hackmd.io/_uploads/Bk-wl4febx.png)

Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int nd(int n, int p) {
	for (int i = 1; i < p; i++) {
		if ((n * i) % p == 1) return i;
	}
}

int main () {
	// E23(1,1)
	int p, xP, yP, xQ, yQ; cin >> p >> xP >> yP >> xQ >> yQ;
	int TS, MS;
	TS = (yQ - yP + p) % p;
	MS = (xQ - xP + p) % p;
	int l = (TS * nd(MS, p)) % p;
	int xR = (mu(l, 2, p) - xP - xQ + p + p) % p;
	int yR = (l*(xP - xR + p)%p - yP + p) % p;
//	cout << l << endl;
	cout << "P + Q = " << xR << " " << yR << endl;
	
	// R - P <=> R + (-P)
	// -P
	yP = p - yP;
	TS = (yP - yR + p) % p;
	MS = (xP - xR + p) % p;
	l = (TS * nd(MS, p)) % p;
	xP = (mu(l, 2, p) - xR - xP + p + p) % p;
	yP = (l*(xR - xP + p)%p - yR + p) % p;
	cout << "R - P = " << xP << " " << yP;
	
	return 0;
}
```

### 9. P(xP, yP) là 1 điểm thuộc Ep(a,b). Lập trình nhập tọa độ điểm P rồi tính tích n.P, với a và p, n nhập từ bàn phím

![image](https://hackmd.io/_uploads/BkGcXHfxbl.png)


Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int nd(int n, int p) {
	for (int i = 1; i < p; i++) {
		if ((n * i) % p == 1) return i;
	}
}

struct Diem {
	int x, y;
};

// 4P = P + P + P + P

struct Diem Tong(int xp, int yp, int xq, int yq, int a, int p) {
	
	// 2 diem trung nhau
	Diem R;
	if (xp == xq && yp == yq) {
		int TS = (3 * mu(xp, 2, p) % p + a) % p;
		int MS = 2 * yp % p;
		int l = TS * nd(MS, p) % p;
		int xr = (mu(l, 2, p) - xp - xp + p + p) % p;
		int yr = (l*(xp - xr + p)%p - yp + p) % p;
		R.x = xr; R.y = yr;
		return R;
	}
	// 2 diem doi nhau
	if (xp == xq && yp == (p-yq)) {
		R.x = -1; R.y = -1;
		return R;
	}
	// 1 trong 2 diem bang diem 0
	if (xp == -1 && yp == -1) {
		R.x = xq; R.y = yq;
		return R;
	} else if (xq == -1 && yq == -1) {
		R.x = xp; R.y = yp;
		return R;
	}
	// TH con lai
	int TS, MS;
	TS = (yq - yp + p) % p;
	MS = (xq - xp + p) % p;
	int l = (TS * nd(MS, p)) % p;
	int xr = (mu(l, 2, p) - xp - xq + p + p) % p;
	int yr = (l*(xp - xr + p)%p - yp + p) % p;
	R.x = xr; R.y = yr;
	return R;
}

int main () {
	
	int n, a, p, xP, yP;
	cin >> n >> a >> p >> xP >> yP;
	Diem R;
	R.x = xP; R.y = yP;
	for (int i = 1; i <= n; i++) {
		R = Tong(R.x, R.y, xP, yP, a, p);
//		cout << R.x << " " << R.y << endl;
	}
	cout << R.x << " " << R.y;
	
	return 0;
}
```

### 10. P(xP, yP) là 1 điểm thuộc Ep(a,b). Lập trình nhập tọa độ điểm P rồi tính bậc n của điểm P đó, với a và p nhập từ bàn phím.
![image](https://hackmd.io/_uploads/BJl1xNSzxWe.png)


Code: 
```c++
#include <bits/stdc++.h>
using namespace std;

int mu(int a, int b, int p) {
	int kq = 1;
	for (int i = 1; i <= b; i++) {
		kq = (kq * a) % p;
	}
	return kq;
}

int nd(int n, int p) {
	for (int i = 1; i < p; i++) {
		if ((n * i) % p == 1) return i;
	}
}

struct Diem {
	int x, y;
};

// 4P = P + P + P + P

struct Diem Tong(int xp, int yp, int xq, int yq, int a, int p) {
	
	// 2 diem trung nhau
	Diem R;
	if (xp == xq && yp == yq) {
		int TS = (3 * mu(xp, 2, p) % p + a) % p;
		int MS = 2 * yp % p;
		int l = TS * nd(MS, p) % p;
		int xr = (mu(l, 2, p) - xp - xp + p + p) % p;
		int yr = (l*(xp - xr + p)%p - yp + p) % p;
		R.x = xr; R.y = yr;
		return R;
	}
	// 2 diem doi nhau
	if (xp == xq && yp == (p-yq)) {
		R.x = -1; R.y = -1;
		return R;
	}
	// 1 trong 2 diem bang diem 0
	if (xp == -1 && yp == -1) {
		R.x = xq; R.y = yq;
		return R;
	} else if (xq == -1 && yq == -1) {
		R.x = xp; R.y = yp;
		return R;
	}
	// TH con lai
	int TS, MS;
	TS = (yq - yp + p) % p;
	MS = (xq - xp + p) % p;
	int l = (TS * nd(MS, p)) % p;
	int xr = (mu(l, 2, p) - xp - xq + p + p) % p;
	int yr = (l*(xp - xr + p)%p - yp + p) % p;
	R.x = xr; R.y = yr;
	return R;
}

int main () {
	
	int a, p, xP, yP;
	cin >> a >> p >> xP >> yP;
	Diem R;
	R.x = xP; R.y = yP;
	int i = 1;
	while(i) {
		R = Tong(R.x, R.y, xP, yP, a, p);
		if (R.x == -1 && R.y == -1) {
			cout << "Bac cua diem la: " << i;
			return 0;
		}
		i++;
//		cout << R.x << " " << R.y << endl;
	}
//	cout << R.x << " " << R.y;
	
	return 0;
}
```
