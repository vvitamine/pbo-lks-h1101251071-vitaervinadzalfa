#!/bin/bash

echo "== Test 1: GET semua buku =="
curl -s http://localhost:8000/api/books
echo -e "\n"

echo "== Test 2: POST buku baru =="
RESPONSE=$(curl -s -X POST -H "Content-Type: application/json" -d '{"judul":"Pulang","penulis":"Tere Liye","tahun":2015,"stok":5}' http://localhost:8000/api/books)
echo $RESPONSE
BOOK_ID=$(echo $RESPONSE | grep -o '"id":[0-9]*' | head -1 | cut -d':' -f2)
echo "ID baru: $BOOK_ID"
echo -e "\n"

echo "== Test 3: GET buku ID $BOOK_ID =="
curl -s http://localhost:8000/api/books/$BOOK_ID
echo -e "\n"

echo "== Test 4: PUT ubah buku =="
curl -s -X PUT -H "Content-Type: application/json" -d '{"judul":"Pulang (Revisi)","penulis":"Tere Liye","tahun":2015,"stok":10}' http://localhost:8000/api/books/$BOOK_ID
echo -e "\n"

echo "== Test 5: DELETE buku =="
curl -s -X DELETE http://localhost:8000/api/books/$BOOK_ID
echo -e "\n"

echo "== Test 6: Validasi error =="
curl -s -X POST -H "Content-Type: application/json" -d '{"judul":"","penulis":"Tere Liye","tahun":2015,"stok":5}' http://localhost:8000/api/books
echo -e "\n"