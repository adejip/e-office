mov a,p0
mov r0,#00h

track:
	cjne a,#01h,hidup1
	jmp track

hidup1:
	cjne r0,#01h,hidup
	mov p1,#01h
	jmp track

hidup:
	cjne r0,#00h,hidup1
	mov p1,#02h
	jmp track
